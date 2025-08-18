import React, { useRef, useState, useEffect } from 'react';

import OverlaySpinner from './OverlaySpinner';
import { useForm } from '@inertiajs/react';

import axios from 'axios'; 

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');

console.log(token);
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found');
}
axios.defaults.withCredentials = true;



const Index = () => {
  const videoRef = useRef(null);
  const canvasRef = useRef(null);
  const [imageUrl, setImageUrl] = useState(null);
  const [captured, setCaptured] = useState(false);
  const [streaming, setStreaming] = useState(false);
  const [stream, setStream] = useState(null);

  const [loading, setLoading] = useState(false);
  const [statusMessage, setStatusMessage] = useState('Loading...');


  const [uploading, setUploading] = useState(false);
  const [errors, setErrors] = useState({});
  const [success, setSuccess] = useState('');



  const [imagePath, setImagePath] = useState(null); // backend relative path for deletion

  const [devices, setDevices] = useState([]);
  const [currentDeviceIndex, setCurrentDeviceIndex] = useState(0);

  // Get list of cameras on load
  useEffect(() => {
    navigator.mediaDevices.enumerateDevices().then((deviceInfos) => {
      const videoDevices = deviceInfos.filter((device) => device.kind === 'videoinput');
      console.log(videoDevices);
      setDevices(videoDevices);
    });


axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector('meta[name="csrf-token"]');

console.log(token);
if (token) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found');
}
axios.defaults.withCredentials = true;

(async ()=>{

await axios.get('/sanctum/csrf-cookie'); // Set CSRF token cookie

})();

  }, []);

  // Start webcam
  const startCamera2 = async () => {
    setStreaming(true);
    
    const mediaStream = await navigator.mediaDevices.getUserMedia({ video: true });
    videoRef.current.srcObject = mediaStream;
    setStream(mediaStream);
    setCaptured(false);
    setImageUrl(null);
  };
  // Start camera with selected device
  const startCamera = async (deviceId = null) => {
    setStreaming(true);
    if (stream) {
      stream.getTracks().forEach((track) => track.stop());
    }

    const constraints = {
      video: deviceId ? { deviceId: { exact: deviceId } } : true,
    };

    const mediaStream = await navigator.mediaDevices.getUserMedia(constraints);
    videoRef.current.srcObject = mediaStream;
    setStream(mediaStream);
    setCaptured(false);
    setImageUrl(null);
    setImagePath(null);
  };

  // Stop webcam
  const stopCamera = () => {
    if (stream) {
      stream.getTracks().forEach(track => track.stop());
    }
    setStreaming(false);
  };

  // Capture photo
  const capturePhoto = () => {
    const context = canvasRef.current.getContext('2d');
    context.drawImage(videoRef.current, 0, 0, 640, 480);
    canvasRef.current.toBlob(uploadPhoto, 'image/jpeg');
    setCaptured(true);
    stopCamera(); // Turn off stream after capture
  };

  // Retake photo
  const retakePhoto2 = () => {
    setCaptured(false);
    startCamera();
  };
  const retakePhoto = async () => {
    if (imagePath) {

      setLoading(true);
      setStatusMessage('Deleting ...');

      await fetch('/api/delete-photo', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify({ path: imagePath }),
      });
    }

    setImageUrl(null);
    setImagePath(null);
    setCaptured(false);
    setLoading(false);
    //startCamera();
    startCamera(devices[currentDeviceIndex].deviceId);
  };

  const retakePhotoAndClose = async () => {
    if (imagePath) {

      setLoading(true);
      setStatusMessage('Deleting ...');

      await fetch('/api/delete-photo', {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify({ path: imagePath }),
      });
      setLoading(false);

      window.location.href=route('dashboard');
    }
 
  };


  const enrollCapture = async (path) => {
    //validating


    if (path) {

      setStatusMessage('Enrolling ...');

      const response = await fetch('/api/enroll-photo', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          Accept: 'application/json',
        },
        body: JSON.stringify({ path }),
      }); 


      setLoading(false);
    }
 
  };


  // Upload to API
  const uploadPhoto = async (blob) => {
    const formData = new FormData();
    formData.append('photo', blob, 'webcam.jpg');

    setLoading(true);
    setStatusMessage('Processing ...');


    setUploading(true);
    setErrors({});
    setSuccess('');
    /*
    const response = await fetch('/api/upload-photo', {
      method: 'POST',
      body: formData,
      headers: {
        Accept: 'application/json',
      },
    });*/
    try {
      const response = await axios.post('/api/upload-photo', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Accept': 'application/json',
        },
      });

      setSuccess('Photo uploaded successfully!');
    } catch (error) {
      if (error.response && error.response.status === 422) {
        setErrors(error.response.data.errors || {});
      } else {
        console.error(error);
      }
    } finally {
      setUploading(false);
    }

    const result = await response.json();
    setImageUrl(result.url);
    setImagePath(result.path);

    console.log(result);

    //setLoading(false);

    await enrollCapture(result.extpath);

    //setImagePath(result.url); // store full URL for deletion
  };

  
  // Switch to the next available camera
  const switchCamera = () => {
    const nextIndex = (currentDeviceIndex + 1) % devices.length;
    setCurrentDeviceIndex(nextIndex);
    startCamera(devices[nextIndex].deviceId);
  };

  return (
    <div>
      <div className="fixed inset-0 bg-gray-400 z-50 flex items-center justify-center">
        
        {/*<div className="absolute z-1 right-3 top-6 w-full flex justify-end gap-4 px-4"> 
            <a href={route('dashboard')}
              className="bg-white text-black px-6 py-2 rounded shadow-lg text-lg" 
            >
              Close
            </a>
        </div>*/}

        {!captured && streaming && (
          <video
            ref={videoRef}
            autoPlay
            playsInline
            muted
            className="w-full h-full object-cover"
          />
        )}
        <canvas ref={canvasRef} width="640" height="480" style={{ display: 'none' }}></canvas>

        {!captured && (
          <div className="absolute bottom-6 w-full flex justify-center gap-4 px-4">
            {!streaming ? (
              <><button
                onClick={()=>{
                  //startCamera();
                  startCamera(devices[currentDeviceIndex].deviceId);
                }}
                className="bg-white text-black px-6 py-2 rounded shadow-lg text-lg"
              >
                Start Camera
              </button>
              <a href={route('dashboard')}
              className="bg-red-600 text-white px-6 py-2 rounded shadow-lg text-lg" 
            >
              Close
            </a></>
            ) : (
            <div className="flex gap-4"> 
              <button
                onClick={capturePhoto}
                className="bg-white text-blue-500 px-6 py-2 rounded shadow-lg text-lg"
              >
                Capture Photo
              </button>
              {devices.length > 1 && (
                <button
                  onClick={switchCamera}
                  className="bg-gray-700 text-white px-6 py-2 rounded shadow text-lg"
                >
                  Switch Camera
                </button>
              )}
              <a href={route('dashboard')}
              className="bg-red-600 text-white px-6 py-2 rounded shadow-lg text-lg" 
            >
              Close
            </a>
            </div>

            )}
          </div>
        )}

        {captured && (
          <div className="min-h-screen bg-gray-900 text-white flex flex-col items-center justify-center px-4 py-6">
            {imageUrl && (
              <img
                src={imageUrl}
                alt="Captured"
                className="w-full max-w-md rounded-lg shadow-lg mb-6"
              />
            )}
            <div className="flex gap-3 justify-center" >
            <button
              onClick={retakePhoto}
              className="bg-red-600 px-6 py-2 rounded shadow text-white text-lg"
            >
              Retake Photo
            </button>
            <button
              //onClick={retakePhoto}
              className="bg-white px-6 py-2 rounded shadow text-blue-500 text-lg"
            >
              Enroll
            </button>
            <button
              onClick={retakePhotoAndClose}
              className="bg-red-600 px-6 py-2 rounded shadow text-white text-lg"
            >
              Close
            </button>


            </div>
          </div>
        )}

      </div>



    </div>
  );
};

export default Index;
