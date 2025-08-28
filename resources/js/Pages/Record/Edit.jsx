import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

import { useForm, usePage } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function ShowRecord({ sl, report }) {
    const { data, setData, patch, processing, errors, reset } = useForm({
        ...report?.meta,
    });
    /*
        name: '',  
        title: '',
        phone: '', 
        address: '',
        city: '',
        state: '',
        lga: '', 
        gender: '', 
        email: '',
        password: '',
        role:'teacher'//add select for it later*/
    const { flash } = usePage().props;

    const handleSubmit = (e) => {
        e.preventDefault();

        patch(route('records.update', { id: report?.id }), {
            preserveScroll: true,
            //onSuccess: () => reset('password'),
        });
    };
    const [lgas, setLgas] = useState({});

    useEffect(() => {
        setLgas(sl[report?.meta?.state_id || 1]?.lgas);
    }, []);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Edit Record
                </h2>
            }
        >
            <Head title="Edit Record" />

            <div className="py-5">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="px-6 text-gray-900">
                            <form
                                onSubmit={handleSubmit}
                                className="grid gap-5 py-5 uppercase"
                            >
                                {/*<div className="text-3xl">Edit Record</div>*/}

                                <div className="grid gap-5 md:grid-cols-3">
                                    <div className="grid">
                                        <label>First name</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.first_name
                                            }
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('first_name', w);
                                            }}
                                        />
                                    </div>

                                    <div className="grid">
                                        <label>Middle name</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.middle_name
                                            }
                                            type="text"
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('middle_name', w);
                                            }}
                                        />
                                    </div>

                                    <div className="grid">
                                        <label>Last name</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.last_name
                                            }
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('last_name', w);
                                            }}
                                        />
                                    </div>

                                    <div className="grid">
                                        <label>Gender</label>
                                        <select
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('gender', w);
                                            }}
                                            defaultValue={report?.meta?.gender}
                                        >
                                            <option value="">
                                                Select Gender ..{' '}
                                            </option>
                                            <option>male</option>
                                            <option>female</option>
                                        </select>
                                    </div>

                                    <div className="grid">
                                        <label>Date of birth</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.date_of_birth
                                            }
                                            type="date"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('date_of_birth', w);
                                            }}
                                        />
                                    </div>
                                </div>

                                <div className="my-1 border-b">Personal</div>

                                <div className="grid gap-5 md:grid-cols-2">
                                    <div className="grid">
                                        <label>RESIDENTIAL ADDRESS</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.home_address
                                            }
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('home_address', w);
                                            }}
                                        />
                                    </div>
                                    <div className="grid">
                                        <label>City</label>
                                        <input
                                            defaultValue={report?.meta?.city}
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('city', w);
                                            }}
                                        />
                                    </div>
                                </div>

                                <div className="my-1 border-b">School</div>

                                <div className="grid gap-5 md:grid-cols-3">
                                    <div className="grid">
                                        <label>SCHOOL NAME</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.school_name
                                            }
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('school_name', w);
                                            }}
                                        />
                                    </div>

                                    <div className="grid">
                                        <label>PRESENT CLASS</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.present_class
                                            }
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('present_class', w);
                                            }}
                                        />
                                    </div>

                                    <div className="grid">
                                        <label>ADMISSION DATE</label>
                                        <input
                                            defaultValue={
                                                report?.meta?.admission_date
                                            }
                                            type="date"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('admission_date', w);
                                            }}
                                        />
                                    </div>
                                </div>

                                <div className="my-1 border-b">
                                    PARENT/GUARDIAN
                                </div>

                                <div className="grid gap-5 md:grid-cols-3">
                                    <div className="grid">
                                        <label>PHONE NUMBER</label>
                                        <input
                                            defaultValue={report?.meta?.phone}
                                            type="text"
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('phone', w);
                                            }}
                                        />
                                    </div>
                                </div>

                                <div className="my-1 border-b">Origin</div>

                                <div className="grid gap-5 md:grid-cols-3">
                                    <div className="grid">
                                        <label>State</label>
                                        <select
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                let lgalist = sl[w];
                                                setLgas(lgalist?.lgas);
                                                setData('state_id', w);
                                            }}
                                            defaultValue={
                                                report?.meta?.state_id
                                            }
                                        >
                                            <option value="">
                                                Select state ..{' '}
                                            </option>
                                            {Object.keys(sl)?.map((x, n) => {
                                                return (
                                                    <option key={n} value={x}>
                                                        {sl[x]?.state_name}
                                                    </option>
                                                );
                                            })}
                                        </select>
                                    </div>
                                    <div className="grid">
                                        <label>LGA</label>
                                        <select
                                            required
                                            onChange={(e) => {
                                                let w = e.target.value;
                                                setData('lga_id', w);
                                            }}
                                            defaultValue={report?.meta?.lga_id}
                                        >
                                            <option value="">Select lga</option>
                                            {Object.keys(lgas)?.map((x, n) => {
                                                return (
                                                    <option key={n} value={x}>
                                                        {lgas[x]}
                                                    </option>
                                                );
                                            })}
                                        </select>
                                    </div>
                                </div>

                                {/* Submit button */}
                                <div className="mt-4">
                                    <button
                                        type="submit"
                                        disabled={processing}
                                        className="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                                    >
                                        {processing
                                            ? 'Updating...'
                                            : 'Update Record'}
                                    </button>
                                </div>
                            </form>

                            {/*JSON.stringify({ report }, null, 2)*/}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
