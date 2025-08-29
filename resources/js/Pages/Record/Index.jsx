import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Pagination from '@/Components/Pagination';

// Helper for date formatting
const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
    });
};

function RecordLocation({ report, sl }) {
    const state = sl[report?.meta?.state_id];
    const lga = state?.lgas?.[report?.meta?.lga_id];
    return (
        <div className="flex flex-col md:flex-row gap-2 md:items-center">
            <div>State: {state?.state_name || 'N/A'}</div>
            <div>LGA: {lga || 'N/A'}</div>
        </div>
    );
}

function RecordName({ meta }) {
    if (!meta) return null;
    return (
        <div className="capitalize flex gap-2 flex-wrap">
            <span>{meta.last_name}</span>
            <span>{meta.middle_name}</span>
            <span>{meta.first_name}</span>
        </div>
    );
}

function RecordDetails({ report, sl }) {
    if (!report?.meta) {
        return (
            <div>
                No details yet<br />
                <Link
                    href={route('records.edit', { id: report?.id })}
                    className="text-blue-500 underline"
                >
                    Add Details
                </Link>
            </div>
        );
    }

    return (
        <div className="grid gap-2">
            <RecordName meta={report.meta} />
            <RecordLocation report={report} sl={sl} />
        </div>
    );
}

export default function IndexRecord({ reports, sl }) {
    const hasReports = reports?.data?.length > 0;

    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this record?')) {
            router.delete(route('records.destroy', id), {
                preserveScroll: true,
            });
        }
    };

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold text-gray-800">
                    Submitted Records
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {!hasReports && (
                        <div className="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                            <div className="p-6 text-gray-900">
                                You have not added any records yet.
                            </div>
                        </div>
                    )}

                    {/* Desktop Table */}
                    {hasReports && (
                        <div className="hidden md:block">
                            <table className="w-full table-auto text-sm">
                                <thead>
                                    <tr className="text-left bg-gray-100">
                                        <th className="px-4 py-2">Photo</th>
                                        <th className="px-4 py-2">Details</th>
                                        <th className="px-4 py-2">Name</th>
                                        <th className="px-4 py-2">Location</th>
                                        <th className="px-4 py-2">Created</th>
                                        <th className="px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {reports.data.map((report, i) => (
                                        <tr
                                            key={i}
                                            className="bg-white border-b hover:bg-gray-50 transition"
                                        >
                                            <td className="px-4 py-3">
                                                {report?.photo ? (
                                                    <img
                                                        className="h-10 w-10 rounded object-cover"
                                                        src={report.photo}
                                                        alt="Report"
                                                    />
                                                ) : (
                                                    <div className="text-gray-400">No Image</div>
                                                )}
                                            </td>
                                            <td className="px-4 py-3 text-gray-900">
                                                <RecordDetails report={report} sl={sl} />
                                            </td>
                                            <td className="px-4 py-3 text-gray-900">
                                                <RecordName meta={report.meta} />
                                            </td>
                                            <td className="px-4 py-3 text-gray-900">
                                                {report.meta && <RecordLocation report={report} sl={sl} />}
                                            </td>
                                            <td className="px-4 py-3 text-gray-600">
                                                {formatDate(report.created_at)}
                                            </td>
                                            <td className="px-4 py-3 space-x-4">
                                                <Link
                                                    href={route('records.show', {
                                                        id: report.id,
                                                    })}
                                                    className="text-blue-600 underline"
                                                >
                                                    View
                                                </Link>
                                                <button
                                                    onClick={() => handleDelete(report.id)}
                                                    className="text-red-600 underline hover:text-red-800"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    )}

                    {/* Mobile Cards */}
                    {hasReports && (
                        <div className="space-y-4 md:hidden">
                            {reports.data.map((report, i) => (
                                <div key={i} className="bg-white shadow rounded p-4">
                                    <div className="flex items-center gap-4 mb-4">
                                        {report?.photo ? (
                                            <img
                                                className="h-16 w-16 rounded object-cover"
                                                src={report.photo}
                                                alt="Report"
                                            />
                                        ) : (
                                            <div className="h-16 w-16 flex items-center justify-center bg-gray-100 text-gray-400 text-xs">
                                                No Image
                                            </div>
                                        )}
                                        <div className="flex-1">
                                            <RecordName meta={report.meta} />
                                            <div className="text-sm text-gray-500">
                                                {formatDate(report.created_at)}
                                            </div>
                                        </div>
                                    </div>
                                    <div className="mb-2">
                                        <strong>Details:</strong>
                                        <div className="text-sm">
                                            <RecordDetails report={report} sl={sl} />
                                        </div>
                                    </div>
                                    <div className="mb-2">
                                        <strong>Location:</strong>
                                        <div className="text-sm">
                                            {report.meta && <RecordLocation report={report} sl={sl} />}
                                        </div>
                                    </div>
                                    <div className="mt-3 flex gap-4 text-sm">
                                        <Link
                                            href={route('records.show', {
                                                id: report.id,
                                            })}
                                            className="text-blue-600 underline"
                                        >
                                            View
                                        </Link>
                                        <button
                                            onClick={() => handleDelete(report.id)}
                                            className="text-red-600 underline hover:text-red-800"
                                        >
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}

                    <div className="mt-6">
                        <Pagination meta={reports} />
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
