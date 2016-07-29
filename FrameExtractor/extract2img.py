# Written by Jerzy Baran 2015
# Modified by Florian Talour 2016

# This code takes filenames (videos) as arguments and extracts each frame
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

	# If the destination direction doesn't exist, create it
	if not os.path.exists("./" + destination):
		os.mkdir("./" + destination)
		os.mkdir("./" + destination + "hq/");

	# Open the file for reading
	file = cv2.VideoCapture(videoFile)
	index = 0	# Used to number the frames

	# Extract a frame
	ret, frame = file.read()
	frame1 = np.copy(frame)
	frame2 = np.copy(frame)

	while ret:

		# the following line was taken from
		# http://nerdfever.com/numpy-goodness-deinterlacing-video-in-numpy/
		# deinterlacing the video
		frame1[1:-1:2] = frame[0:-2:2]/2 + frame[2::2]/2

		index, hashed = hashName(destination, videoFile, index)
		cv2.imwrite(destination + hashed + ".jpg", frame1, 
			[int(cv2.IMWRITE_JPEG_QUALITY), 80])
		cv2.imwrite(destination + "hq/" + hashed + ".jpg", 
			frame1, [int(cv2.IMWRITE_JPEG_QUALITY), 100])

		# lines writtens by Florian TALOUR
		frame2[0][:] = frame[0][:]/2 + frame[1][:]/2
		frame2[2:-2:2] = frame[1:-3:2]/2 + frame[3:-1:2]/2
		frame2[-1][:] = frame[-2][:]/2 + frame[-1][:]/2

		cv2.imwrite(destination + hashed + ".jpg", frame2, 
			[int(cv2.IMWRITE_JPEG_QUALITY), 80])
		cv2.imwrite(destination + "hq/" + hashed + ".jpg", 
			frame2, [int(cv2.IMWRITE_JPEG_QUALITY), 100])

		# Extract the next frame
		ret, frame = file.read()
		frame1 = np.copy(frame)
		frame2 = np.copy(frame)

		# index += 1

	file.release()

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
