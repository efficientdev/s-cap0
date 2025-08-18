import React, { useEffect, useState } from 'react';
import { Head, Link } from '@inertiajs/react';
export default function Welcome({ auth, laravelVersion, phpVersion }) {
    const handleImageError = () => {
        document
            .getElementById('screenshot-container')
            ?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document
            .getElementById('docs-card-content')
            ?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };
  const [countdown, setCountdown] = useState('');
  const [showCountdown, setShowCountdown] = useState(false);

  useEffect(() => {
    const countDownDate = new Date("Jan 13, 2023 23:59:59").getTime();

    const interval = setInterval(() => {
      const now = new Date().getTime();
      const distance = countDownDate - now;

      if (distance < 0) {
        clearInterval(interval);
        setCountdown('');
        return;
      }

      const days = Math.floor(distance / (1000 * 60 * 60 * 24));
      const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((distance % (1000 * 60)) / 1000);

      const message = `The deadline of Dec. 30th has been postponed. Due to the holiday, an extension has been granted till Friday Jan. 13th 2023. Note that a late registration fee of N50,000 has been added. Consult the MoE hotline for more information.`;

      setCountdown(`${days} days ${hours} hours ${minutes} minutes ${seconds} seconds to go. ${message}`);
      setShowCountdown(true);
    }, 1000);

    return () => clearInterval(interval);
  }, []);

  return (
    <div className="flex items-center justify-center h-screen bg-white text-gray-700 font-sans">
      <div className="text-center">
        <img
          alt="Edo State Government"
          height="95"
          width="120"
          className="inline-block mb-5"
          src="https://medu.edostategov.com.ng/v1/img/edo-state-government.png"
          title="Edo State Government"
        />
        <img
          alt="Edo State Government"
          height="115"
          width="140"
          className="inline-block mb-5 ml-3"
          src="https://medu.edostategov.com.ng/v1/img/logo2.jpg"
          title="Edo State Government"
        />
        <h1 className="text-4xl font-semibold mb-2">Edo State Ministry of Education</h1>
        <div className="text-2xl font-semibold mb-6">Model School Registration portal</div>
        <div className="space-x-4 text-sm uppercase tracking-wider mb-6">
        <Link
            href={route('login')}
            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
        >
            Log in
        </Link>
        <span>|</span>

        <Link
            href={route('register')}
            className="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] "
        >
            Register
        </Link>
        {/*}
        <span>|</span>*/}
          
          </div>
        {showCountdown && (
          <p className="mt-4 text-sm text-gray-600" id="demo">{countdown}</p>
        )}
      </div>
    </div>
  );
};
 