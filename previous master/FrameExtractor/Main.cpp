/*
* Author:	Povilas Auskalnis
*			Jerzy Baran
*
* 
*/

#include <opencv2/highgui/highgui.hpp>

// #include <stdio.h>
// #include <stdlib.h>
#include <stdio.h>
#include <vector>
#include <string>

using namespace cv;
using namespace std;

int main(int args, const char** argv){

	//check if we have a correct argument, ignore the program name
	if(args <= 1){

		printf("FrameExtractor [video_file]\n\n");
		return 0;
	}

	const char* fileName = argv[1];

	//0th string is the name of the program
	printf("Loading %s\n", fileName);

	//open the video file
	VideoCapture cap(fileName);	//the destructor will deallocate memory automatically

	//check for failure
	if(!cap.isOpened()){

		printf("Could not open %s, is it a video file?\n", fileName);
	}

	vector<int> compression_params;
	compression_params.push_back(CV_IMWRITE_JPEG_QUALITY);
	compression_params.push_back(100);	//compression quality

	Mat frame;		//image
	string name = "frame";	//base file name under which frames will be saved
	string tmpName = name;
	int count = 0;			//how many frames were read
	bool nextFrame = cap.read(frame);	//read the first frame

	string file = tmpName.append(to_string(count)).append(".jpg");
	bool frameSaved = imwrite(file, frame, compression_params);	//save it
	count++;

	//keep reading while there are frames
	while(nextFrame && frameSaved){

		//read next frame
		nextFrame = cap.read(frame);

		//save it to file

		tmpName = name;
		file = tmpName.append(to_string(count)).append(".jpg");
		frameSaved = imwrite(file, frame, compression_params);

		count++;
	}

	return 0;
}