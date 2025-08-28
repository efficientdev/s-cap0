import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function ShowRecord({ sl, report }) {
    function Fi() {
        let state1 = sl[report?.meta?.state_id];

        let lgas = state1?.lgas;

        return (
            <div>
                State: {state1?.state_name}
                <br />
                LGA: {lgas[report?.meta?.lga_id]}
                <br />
            </div>
        );
    }
    const setData = (c, s) => {};

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    {report?.meta?.last_name} {report?.meta?.first_name} -
                    Student Record
                </h2>
            }
        >
            <Head title="Student Record" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            <div className="flex justify-end">
                                <img
                                    className="h-10 w-10"
                                    src={report?.photo}
                                />
                            </div>

                            <div className="grid gap-5 md:grid-cols-3">
                                <div className="grid">
                                    <label>First name</label>
                                    <label>{report?.meta?.first_name}</label>
                                </div>

                                <div className="grid">
                                    <label>Middle name</label>
                                    <label>{report?.meta?.middle_name}</label>
                                </div>

                                <div className="grid">
                                    <label>Last name</label>
                                    <label>{report?.meta?.last_name}</label>
                                </div>

                                <div className="grid">
                                    <label>Gender</label>
                                    <label>{report?.meta?.gender}</label>
                                </div>

                                <div className="grid">
                                    <label>Date of birth</label>
                                    <label>{report?.meta?.date_of_birth}</label>
                                </div>
                            </div>

                            <div className="my-2 mt-4 border-b">Personal</div>

                            <div className="grid gap-5 md:grid-cols-2">
                                <div className="grid">
                                    <label>RESIDENTIAL ADDRESS</label>
                                    <label>{report?.meta?.home_address}</label>
                                </div>
                                <div className="grid">
                                    <label>City</label>
                                    <label>{report?.meta?.city}</label>
                                </div>
                            </div>

                            <div className="my-2 mt-4 border-b">School</div>

                            <div className="grid gap-5 md:grid-cols-3">
                                <div className="grid">
                                    <label>SCHOOL NAME</label>
                                    <label>{report?.meta?.school_name}</label>
                                </div>

                                <div className="grid">
                                    <label>PRESENT CLASS</label>
                                    <label>{report?.meta?.present_class}</label>
                                </div>

                                <div className="grid">
                                    <label>ADMISSION DATE</label>
                                    <label>
                                        {report?.meta?.admission_date}
                                    </label>
                                </div>
                            </div>

                            <div className="my-2 mt-4 border-b">
                                PARENT/GUARDIAN
                            </div>

                            <div className="grid gap-5 md:grid-cols-3">
                                <div className="grid">
                                    <label>PHONE NUMBER</label>
                                    <label>{report?.meta?.phone}</label>
                                </div>
                            </div>

                            <div className="my-1 border-b">Origin</div>
                            <Fi />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
