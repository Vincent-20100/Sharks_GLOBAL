# Written by Jerzy Baran 2016

# This code takes a picture with some coordinates and saves a cropped version

import sys
import os
import numpy as np
import cv2

def printUsage():
	print "Usage:"
	print "crop.py dest image x y width height"
	print "Where dest is a relative path ending with /"

def printInfo():
	print "Python Image Crop, using OpenCV " + cv2.__version__

def cropImage(destination, imageFile, x, y, width, height):
	# If the destination direction doesn't exist, create it
	if not os.path.exists("./" + destination):
		os.mkdir("./" + destination)

	img = cv2.imread(imageFile)
	
	# Do not allow negative coordinates
	# OpenCV takes care of widths/heights that are too big for the image

	imgHeight, imgWidth = img.shape[:2]

	if x < 0:
		x = 0
	if y < 0:
		y = 0
	if width < 0:
		width = 0
	if height < 0:
		height = 0
	if x >= imgWidth:
		x = imgWidth - 1	# OpenCV breaks when x == exact width of image
	if y >= imgHeight:
		y = imgHeight - 1	# Same with y

	cropped = img[y:y + height, x:x + width]

	# Be careful not to overwrite the original image
	fileName = destination + imageFile
	if os.path.exists(fileName):
		fileName = destination + "cropped_" + imageFile

	cv2.imwrite(fileName, cropped)

def main(argv):
	#argv[0] = destination directory
	#argv[1] = image file
	#argv[2] = x
	#argv[3] = y
	#argv[4] = width
	#argv[5] = height

	destination = argv[0]
	file = argv[1]
	print "Cropping " + file + " to " + destination

	cropImage(destination, file,
		int(argv[2]), int(argv[3]),	# x, y
		int(argv[4]), int(argv[5]))	# w, h

if __name__ == "__main__":
	if(len(sys.argv) > 1 and sys.argv[1] == "--i"):
		printInfo();
		sys.exit();

	if len(sys.argv) < 6:
		print "Pass 6 arguments"
		print ""
		printUsage()
		sys.exit()

	main(sys.argv[1:])