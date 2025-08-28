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
{report?.data?.map((item,i)=>{
    return (<div className="my-5" key={i}>

        {JSON.stringify(item,null,2)}<br/>
        {Array.isArray(item?.notes) && item?.notes?.map((nitem,ni)=>{
            return (<div className="my-1" key={ni}>
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
