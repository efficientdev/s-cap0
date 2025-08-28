import { Link } from '@inertiajs/react';

export default function Pagination({ meta }) {
  if (!meta || !meta.links || meta.links.length <= 3) return null; // nothing to paginate

  return (
    <div className="mt-4">
      <nav className="flex justify-center">
        <ul className="inline-flex -space-x-px">
          {meta.links.map((link, index) => {
            // Force https in URLs if link.url exists
            const secureUrl = link.url ? link.url.replace(/^http/i, 'https') : null;

            return (
              <li key={index}>
                {secureUrl ? (
                  <Link
                    href={secureUrl}
                    className={`px-4 py-2 border text-sm ${
                      link.active
                        ? 'bg-blue-500 text-white border-blue-500'
                        : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100'
                    }`}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                  />
                ) : (
                  <span
                    className="px-4 py-2 border text-sm text-gray-400 border-gray-300"
                    dangerouslySetInnerHTML={{ __html: link.label }}
                  />
                )}
              </li>
            );
          })}
        </ul>
      </nav>
    </div>
  );
}
