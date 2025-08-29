import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

function RecordLocation({ report, sl, schools,classes }) {
    const state = sl[report?.meta?.state_id];
    const lga = state?.lgas?.[report?.meta?.lga_id];

    return (
        <div className="grid gap-2 mt-4 text-sm text-gray-800">
            <div className="font-semibold border-b pb-1">Origin</div>
            <div className="flex gap-4 flex-wrap">
                <div>State: {state?.state_name || 'N/A'}</div>
                <div>LGA: {lga || 'N/A'}</div>
            </div>
        </div>
    );
}

export default function ShowRecord({ sl, report }) {
    const meta = report?.meta;

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold text-gray-800">
                    {meta?.last_name} {meta?.first_name} – Student Record
                </h2>
            }
        >
            <Head title="Student Record" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                        <div className="p-6 text-gray-900 space-y-8">

                            {/* Photo */}
                            <div className="flex justify-end">
                                {report?.photo ? (
                                    <img
                                        src={report.photo}
                                        alt="Student"
                                        className="w-20 h-20 object-cover rounded border"
                                    />
                                ) : (
                                    <div className="text-gray-400 italic">
                                        No Photo
                                    </div>
                                )}
                            </div>

                            {/* Bio Info */}
                            <div>
                                <div className="text-lg font-semibold mb-2 border-b pb-1">
                                    Bio Information
                                </div>
                                <div className="grid gap-5 md:grid-cols-3">
                                    <InfoField label="First Name" value={meta?.first_name} />
                                    <InfoField label="Middle Name" value={meta?.middle_name} />
                                    <InfoField label="Last Name" value={meta?.last_name} />
                                    <InfoField label="Gender" value={meta?.gender} />
                                    <InfoField label="Date of Birth" value={meta?.date_of_birth} />
                                </div>
                            </div>

                            {/* Personal */}
                            <div>
                                <div className="text-lg font-semibold mb-2 border-b pb-1">
                                    Personal
                                </div>
                                <div className="grid gap-5 md:grid-cols-2">
                                    <InfoField label="Residential Address" value={meta?.home_address} />
                                    <InfoField label="City" value={meta?.city} />
                                </div>
                            </div>

                            {/* School */}
                            <div>
                                <div className="text-lg font-semibold mb-2 border-b pb-1">
                                    School
                                </div>
                                <div className="grid gap-5 md:grid-cols-3">
                                    {/*<InfoField label="School Name" value={meta?.school_name} />
                                    <InfoField label="Present Class" value={meta?.present_class} />

                                    */}

                                    <InfoField label="School Name" value={schools[report?.meta?.school_id]?.name} />
                                    <InfoField label="Present Class" value={classes[report?.meta?.class_list_id]?.name} />

                                    
                                        

                                    <InfoField label="Admission Date" value={meta?.admission_date} />
                                </div>
                            </div>

                            {/* Guardian */}
                            <div>
                                <div className="text-lg font-semibold mb-2 border-b pb-1">
                                    Parent / Guardian
                                </div>
                                <div className="grid gap-5 md:grid-cols-3">
                                    <InfoField label="Phone Number" value={meta?.phone} />
                                </div>
                            </div>

                            {/* Origin */}
                            <RecordLocation report={report} sl={sl} />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

// Reusable Info Field Component
function InfoField({ label, value }) {
    return (
        <div className="grid text-sm">
            <label className="text-gray-500 uppercase text-xs font-semibold tracking-wide">{label}</label>
            <div className="text-gray-900">{value || '—'}</div>
        </div>
    );
}
