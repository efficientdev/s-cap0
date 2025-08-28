import React from 'react';

const OverlaySpinner = ({ isVisible, message }) => {
  if (!isVisible) return null;

  return (
    <div className="fixed top-0 h-[100vh] right-0 left-0 bottom-0 inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div className="flex flex-col items-center space-y-4">
        <div className="w-12 h-12 border-4 border-white border-t-transparent rounded-full animate-spin" />
        <p className="text-white text-lg text-center">{message}</p>
      </div>
    </div>
  );
};

export default OverlaySpinner;
