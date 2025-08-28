import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

import Pagination from '@/Components/Pagination';

export default function IndexRecord({ reports, sl }) {

    function Fi({report}){
        let state1=sl[report?.meta?.state_id];

        let lgas=state1?.lgas;

        return (<div className="grid md:flex  gap-5 item-center">
        <div>State: {state1?.state_name} </div>
        <div>LGA: {lgas[report?.meta?.lga_id]} </div>
        </div>)
    }
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800">
                    Submitted Records
                </h2>
            }
        >
            <Head title="Dashboard" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {reports?.data?.length == 0 ? (
                        <div>
                            <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900">
                                    You have not added any records yet.
                                </div>
                            </div>
                        </div>
                    ) : null}

                    <table className="w-full">
                        <tbody>
                            {reports?.data?.map((report, i) => {
                                return (
                                    <tr
                                        key={i}
                                        className="overflow-hidden bg-white border-b p-2 my-1 shadow-sm sm:rounded-lg"
                                    >
                                        <td className="px-2 py-5">
                                            <img
                                                className="h-5 w-5"
                                                src={report?.photo}
                                            />
                                        </td>
                                        <td className="px-6 text-gray-900">
                                            {!report?.meta ? (
                                                <div>
                                                    No details yet
                                                    <br />
                                                    <Link
                                                        href={route(
                                                            'records.edit',
                                                            {
                                                                id: report?.id,
                                                            },
                                                        )}
                                                    >
                                                        Add Details
                                                    </Link>
                                                </div>
                                            ) :  <div className="grid"> 
                                            </div>} 

                                        </td>
                                        <td className="px-6 text-gray-900">
                                        {!report?.meta ? (
                                                <div>
                                                     
                                                </div>
                                            ) :  <div className="grid"><div className="grid md:flex capitalize gap-2 items-center">
                                            <div>{report?.meta?.last_name||''}</div>
                                            <div>{report?.meta?.middle_name||''}</div>
                                            <div>{report?.meta?.first_name||''}</div></div> 
                                            </div>} 
                                            {/*JSON.stringify(report, null, 2)*/}
                                        </td>

                                        <td className="px-6 text-gray-900">
                                        {!report?.meta ? (
                                                <div>
                                                     
                                                </div>
                                            ) :  <div className="grid"> 
                                            <Fi report= {report} />
                                            </div>} 
                                            {/*JSON.stringify(report, null, 2)*/}
                                        </td>

                                        <td>
                                            {report?.created_at}
                                        </td>
                                        <td>
                                            <Link
                                                href={route('records.show', {
                                                    id: report?.id,
                                                })}
                                            >
                                                View
                                            </Link>
                                        </td>
                                    </tr>
                                );
                            })}
                        </tbody>
                    </table>

                    <Pagination meta={reports} />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
