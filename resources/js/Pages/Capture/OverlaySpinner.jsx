import React from 'react';

const OverlaySpinner = ({ isVisible, message }) => {
  if (!isVisible) return null;
//bg-opacity-50
  return (
    <div className={`${!isVisible?'hidden':'fixed'}  top-0 h-[100vh] right-0 left-0 bottom-0 inset-0 bg-black  z-50 flex items-center justify-center  `}>
      <div className="flex flex-col items-center space-y-4">
        <div className="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin" />
        <p className="text-white text-lg text-center">{message}</p>
      </div>
    </div>
  );
};

export default OverlaySpinner;
