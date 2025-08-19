import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import React, { useRef, useState, useEffect } from 'react';

export default function Index({report}) {

    useEffect(()=>{
        console.log({report});
    },[report]);

    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Capture Logs
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900">
                            Capture Logs
<hr/>
<>
{report?.map((item,i)=>{
    return (<div key={i}>

        {Array.isArray(item?.notes) && item?.notes?.map((nitem,ni)=>{
            return (<div key={ni}>
            {JSON.stringify(nitem,null,2)}
            <hr/>
            </div>);
        })}

    </div>);
})}
</>

                            {/*JSON.stringify(report,null,2)*/}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
