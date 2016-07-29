# Written by Florian Talour & Tristan Lenair 2016

# This code takes files names (videos) as arguments and extracts each frame
# from them.

import hashlib
import sys
import os
import cv2
import numpy as np

def printUsage():
	print ("Usage:")
	print ("extract.py dest file [file, ...]")
	print ("Where dest is a relative path ending with /")

def printInfo():
	print ("Python Frame Etractor, using OpenCV " + cv2.__version__)

def hashName(destination, fileName, index):
	'''not used'''
	fileName = fileName + "%d" % index
	hashed = hashlib.sha512(fileName)
	hashed = hashed.hexdigest()
	index += 1

	# Try to find a hashed that does'nt exist
	while os.path.exists(destination + hashed + ".jpg"):
		fileName = fileName + "%d" % index
		hashed = hashlib.sha512(fileName)
		hashed = hashed.hexdigest()
		index += 1

	return index, hashed

def processVideo(destination, videoFile):
	'''create the direcoties for the pictures and read the file'''
	
	# If the destination direction doesn't exist, create it
	if not os.path.exists("./" + destination):
		os.mkdir("./" + destination) # pictures 80% quality
		os.mkdir("./" + destination + "hq/") # picture 100% quality

	# Open the file for reading
	file = cv2.VideoCapture(videoFile)

	# Read the file first image
	ret, framePrec = file.read()
	if ret:
		ret, frameCurr = file.read()

	height = frameCurr.shape[0] # frame height
	width = frameCurr.shape[1] # frame width

	# md will contain the motion detector value of the current and previous frame
	# the three 0 are the RGB values
	md = np.zeros((2, height, width, 3))

	index = 0 # Used to number the frames

	while ret:

		# Proposed Motion and Edge Adaptive Interpolation De-interlacing Method 
		# Proposed algorithm from http://i.cs.hku.hk/~hychung/pub/kykwong_cscc06.pdf
		for y in range(1, height-2, 2):
			for x in range(1, width-2):
			
				md[1][y][x] = MotionDetection(x,y, framePrec, frameCurr, md)
				frameCurr[y][x] = Fd(x,y, framePrec, frameCurr, md)

		md[0] = np.copy(md[1])
		framePrec = np.copy(frameCurr)
		
		cv2.imwrite(destination + str(index) + ".jpg", frameCurr, [int(cv2.IMWRITE_JPEG_QUALITY), 80])
		cv2.imwrite(destination + "hq/" + str(index) + ".jpg", frameCurr, [int(cv2.IMWRITE_JPEG_QUALITY), 100])
		
		ret, frameCurr = file.read()
		index += 1
		

	file.release()


def Fi(x, y, frameCurr):
	'''return the  current frame pixel at position (x, y)'''
	return frameCurr[y][x]

def Fd(x, y, framePrec, frameCurr, matMD):
	'''return a pixel frame to contitute a De-intelaced frame'''
	# y should always be odd because of the range step
	if y % 2 == 0:
		return Fi(x,y,frameCurr)
	elif y % 2 != 0:
		return IN(x, y, framePrec, frameCurr, matMD)

def IN(x, y, framePrec, frameCurr, matMD):
	'''Interpolation function within a window of size 3 around the (x,y) coordinates'''
	T = 32 #8, 16, 32 , 64
	
	currMatMD = matMD[1][y][x]

	# interpolations coefficients
	au = (currMatMD*currMatMD) / (2*currMatMD*currMatMD + T*T) #coefficient for upside pixel
	al = au #coefficient for downside pixel
	aB = T*T / (2*currMatMD*currMatMD + T*T) # aB = 1 - au - al = 1 - 2*au

	# edge orientation 45: k = 1
	Edge45 = brighness(Fi(x+1, y-1, frameCurr) - Fi(x-1, y+1, framePrec))
	# edge orientation -45: k = -1
	EdgeMinus45 = brighness(Fi(x-1, y-1, frameCurr) - Fi(x+1, y+1, framePrec))
	# edge orientation 90: k = 0
	Edge90 = brighness(Fi(x, y-1, frameCurr) - Fi(x, y+1, framePrec))

	# look for an edge orientation where the brithness delta is minimum
	minusEdge = min(Edge45, EdgeMinus45, Edge90)
	if minusEdge == Edge45:
		k = 1 # edge orientation 45
	elif minusEdge == EdgeMinus45:
		k = -1 # edge orientation -45
	elif minusEdge == Edge90:
		k = 0 # edge orientation 90

	# We use Fi(x+1,y-1,frameCurr) instead of frameCurr[y-1][x+1] to have a better visibility of what is done
	return au*Fi(x+k,y-1,frameCurr) + aB*Fi(x,y,frameCurr) + al*Fi(x-k,y+1,frameCurr)

	'''\
	return (1/6) * (au*Fi(x+1,y-1,frameCurr) + aB*Fi(x,y,frameCurr) + al*Fi(x-1,y+1,frameCurr)) \
		+ (4/6) * (au*Fi(x,y-1,frameCurr) + aB*Fi(x,y,frameCurr) + al*Fi(x,y+1,frameCurr)) \
		+ (1/6) * (au*Fi(x+1,y-1,frameCurr) + aB*Fi(x,y,frameCurr) + al*Fi(x+1,y+1,frameCurr))
	'''

def MAD(x, y, framePrec, frameCurr):
	'''Mean-absolute-difference
	return an average moving value by comparing the pixels around between the current and previous frame'''
	res = 0
	# i and j can take value between -1 and 1
	for i in range(-1,2):
		for j in range(-1,2):
			res += abs(Fi(x+i, y+j, frameCurr) - Fi(x+i, y+j, framePrec))

	return (1 / 9) * res


def MotionDetection(x, y, framePrec, frameCurr, matMD):
	'''Motion detector'''
	prevMatMD = matMD[0][y][x]
	mad = MAD(x, y, framePrec, frameCurr)
	if brighness(mad) >= brighness(prevMatMD):
		return MAD(x, y, framePrec, frameCurr)
	else:
		return (MAD(x, y, framePrec, frameCurr) + prevMatMD) / 2 # average prevMD mtrice and MAD 

def brighness(tab):
	return (0.2126*tab[0] + 0.7152*tab[1] + 0.0722*tab[2])

def main(argv):
	print ("Preparing to process %d videos" % (len(argv) - 1))

	destination = argv[0]
	print ("Extracting to " + destination)

	for index in range(1, len(argv)):
		print ("From " + argv[index])
		processVideo(destination, argv[index])

if __name__ == "__main__":
	if len(sys.argv) > 1 and sys.argv[1] == "--i":
		printInfo()
		sys.exit()

	if len(sys.argv) <= 2:
		print ("Pass at least two arguments\n")
		printUsage()
		sys.exit()

	main(sys.argv[1:])
