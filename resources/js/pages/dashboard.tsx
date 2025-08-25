import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';

interface Props {
    user: {
        id: number;
        name: string;
        email: string;
        role: string;
        phone?: string;
        address?: string;
        jamaah?: {
            id: number;
            full_name: string;
            status: string;
            nik: string;
        };
    };
    admin_stats?: {
        total_users: number;
        superadmin_count: number;
        staffadmin_count: number;
        jamaah_count: number;
        total_revenue: number;
        total_expenses: number;
    };
    staff_stats?: {
        jamaah_count: number;
        pending_documents: number;
        pending_payments: number;
        overdue_payments: number;
        equipment_low_stock: number;
    };
    jamaah_data?: {
        profile: object;
        assignment: {
            travel_package?: {
                name: string;
                departure_date: string;
            };
            accommodation?: {
                name: string;
                location: string;
            };
            departure_flight?: {
                flight_number: string;
            };
            room_number?: string;
            seat_number_departure?: string;
        } | null;
        documents: object[];
        payments: object[];
        equipment: object[];
    };
    [key: string]: unknown;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard({ user, admin_stats, staff_stats, jamaah_data }: Props) {
    const getRoleName = (role: string) => {
        const roles: Record<string, string> = {
            'superadmin': 'Super Administrator',
            'staffadmin': 'Staff Administrator', 
            'jamaah': 'Jamaah',
        };
        return roles[role] || role;
    };

    const getRoleEmoji = (role: string) => {
        const emojis: Record<string, string> = {
            'superadmin': '👑',
            'staffadmin': '👨‍💼',
            'jamaah': '🕋',
        };
        return emojis[role] || '👤';
    };

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            
            <div className="space-y-6">
                {/* Welcome Header */}
                <div className="bg-gradient-to-r from-emerald-500 to-blue-600 rounded-xl p-6 text-white">
                    <div className="flex items-center justify-between">
                        <div>
                            <h1 className="text-3xl font-bold">
                                {getRoleEmoji(user.role)} Selamat Datang, {user.name}!
                            </h1>
                            <p className="text-emerald-100 mt-2">
                                {getRoleName(user.role)} - PT Hikami Mandiri Indonesia
                            </p>
                        </div>
                        <div className="text-right">
                            <div className="text-emerald-100 text-sm">Login sebagai</div>
                            <div className="text-xl font-semibold">{getRoleName(user.role)}</div>
                        </div>
                    </div>
                </div>

                {/* Superadmin Dashboard */}
                {user.role === 'superadmin' && admin_stats && (
                    <div className="space-y-6">
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white">📊 Statistik Sistem</h2>
                        
                        {/* Admin Stats Cards */}
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-400">Total Pengguna</p>
                                        <p className="text-3xl font-bold text-blue-600">{admin_stats.total_users}</p>
                                    </div>
                                    <div className="text-4xl text-blue-500">👥</div>
                                </div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-400">Total Revenue</p>
                                        <p className="text-3xl font-bold text-green-600">
                                            {new Intl.NumberFormat('id-ID', { 
                                                style: 'currency', 
                                                currency: 'IDR',
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0
                                            }).format(admin_stats.total_revenue)}
                                        </p>
                                    </div>
                                    <div className="text-4xl text-green-500">💰</div>
                                </div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-400">Total Expenses</p>
                                        <p className="text-3xl font-bold text-red-600">
                                            {new Intl.NumberFormat('id-ID', { 
                                                style: 'currency', 
                                                currency: 'IDR',
                                                minimumFractionDigits: 0,
                                                maximumFractionDigits: 0
                                            }).format(admin_stats.total_expenses)}
                                        </p>
                                    </div>
                                    <div className="text-4xl text-red-500">📊</div>
                                </div>
                            </div>
                        </div>

                        {/* User Breakdown */}
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                            <h3 className="text-lg font-semibold mb-4">Breakdown Pengguna</h3>
                            <div className="grid grid-cols-3 gap-4">
                                <div className="text-center">
                                    <div className="text-2xl font-bold text-purple-600">{admin_stats.superadmin_count}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">👑 Superadmin</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-2xl font-bold text-blue-600">{admin_stats.staffadmin_count}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">👨‍💼 Staff Admin</div>
                                </div>
                                <div className="text-center">
                                    <div className="text-2xl font-bold text-emerald-600">{admin_stats.jamaah_count}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">🕋 Jamaah</div>
                                </div>
                            </div>
                        </div>

                        {/* Quick Actions */}
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                            <h3 className="text-lg font-semibold mb-4">🚀 Aksi Cepat</h3>
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <Link 
                                    href={route('users.index')} 
                                    className="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors"
                                >
                                    <span className="text-2xl mr-3">👥</span>
                                    <span className="font-medium">Kelola Pengguna</span>
                                </Link>
                                <Link 
                                    href={route('jamaah.index')} 
                                    className="flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors"
                                >
                                    <span className="text-2xl mr-3">🕋</span>
                                    <span className="font-medium">Data Jamaah</span>
                                </Link>
                                <div className="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                    <span className="text-2xl mr-3">📊</span>
                                    <span className="font-medium">Laporan Keuangan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Staff Admin Dashboard */}
                {user.role === 'staffadmin' && staff_stats && (
                    <div className="space-y-6">
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white">📋 Dashboard Staff</h2>
                        
                        {/* Staff Stats Cards */}
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-400">Total Jamaah</p>
                                        <p className="text-3xl font-bold text-emerald-600">{staff_stats.jamaah_count}</p>
                                    </div>
                                    <div className="text-4xl text-emerald-500">🕋</div>
                                </div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-400">Dokumen Pending</p>
                                        <p className="text-3xl font-bold text-orange-600">{staff_stats.pending_documents}</p>
                                    </div>
                                    <div className="text-4xl text-orange-500">📄</div>
                                </div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                <div className="flex items-center justify-between">
                                    <div>
                                        <p className="text-gray-600 dark:text-gray-400">Pembayaran Tertunda</p>
                                        <p className="text-3xl font-bold text-red-600">{staff_stats.pending_payments}</p>
                                    </div>
                                    <div className="text-4xl text-red-500">💳</div>
                                </div>
                            </div>
                        </div>

                        {/* Quick Actions */}
                        <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                            <h3 className="text-lg font-semibold mb-4">🚀 Aksi Cepat</h3>
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <Link 
                                    href={route('jamaah.index')} 
                                    className="flex items-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors"
                                >
                                    <span className="text-2xl mr-3">🕋</span>
                                    <span className="font-medium">Kelola Jamaah</span>
                                </Link>
                                <div className="flex items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                    <span className="text-2xl mr-3">📄</span>
                                    <span className="font-medium">Dokumen</span>
                                </div>
                                <div className="flex items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <span className="text-2xl mr-3">🎒</span>
                                    <span className="font-medium">Perlengkapan</span>
                                </div>
                                <div className="flex items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                    <span className="text-2xl mr-3">💰</span>
                                    <span className="font-medium">Keuangan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Jamaah Dashboard */}
                {user.role === 'jamaah' && (
                    <div className="space-y-6">
                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white">🕋 Dashboard Jamaah</h2>
                        
                        {user.jamaah ? (
                            <div className="space-y-6">
                                {/* Profile Status */}
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                    <h3 className="text-lg font-semibold mb-4">👤 Status Profil</h3>
                                    <div className="flex items-center justify-between">
                                        <div>
                                            <p className="font-medium">{user.jamaah.full_name}</p>
                                            <p className="text-sm text-gray-600 dark:text-gray-400">NIK: {user.jamaah.nik}</p>
                                        </div>
                                        <div className="text-right">
                                            <span className="px-3 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 rounded-full text-sm">
                                                {user.jamaah.status}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                {/* Quick Overview Cards */}
                                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                        <div className="text-center">
                                            <div className="text-3xl mb-2">📄</div>
                                            <div className="text-2xl font-bold text-purple-600">
                                                {jamaah_data?.documents?.length || 0}
                                            </div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Dokumen</div>
                                        </div>
                                    </div>

                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                        <div className="text-center">
                                            <div className="text-3xl mb-2">💰</div>
                                            <div className="text-2xl font-bold text-green-600">
                                                {jamaah_data?.payments?.length || 0}
                                            </div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Pembayaran</div>
                                        </div>
                                    </div>

                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                        <div className="text-center">
                                            <div className="text-3xl mb-2">🎒</div>
                                            <div className="text-2xl font-bold text-blue-600">
                                                {jamaah_data?.equipment?.length || 0}
                                            </div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Perlengkapan</div>
                                        </div>
                                    </div>

                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                        <div className="text-center">
                                            <div className="text-3xl mb-2">✈️</div>
                                            <div className="text-2xl font-bold text-indigo-600">
                                                {jamaah_data?.assignment ? '1' : '0'}
                                            </div>
                                            <div className="text-sm text-gray-600 dark:text-gray-400">Paket Travel</div>
                                        </div>
                                    </div>
                                </div>

                                {/* Travel Package Info */}
                                {jamaah_data?.assignment && (
                                    <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                        <h3 className="text-lg font-semibold mb-4">✈️ Informasi Perjalanan</h3>
                                        <div className="space-y-4">
                                            <div>
                                                <p className="font-medium">{jamaah_data.assignment.travel_package?.name}</p>
                                                <p className="text-sm text-gray-600 dark:text-gray-400">
                                                    Keberangkatan: {jamaah_data.assignment.travel_package?.departure_date 
                                                        ? new Date(jamaah_data.assignment.travel_package.departure_date).toLocaleDateString('id-ID')
                                                        : '-'}
                                                </p>
                                            </div>
                                            
                                            {jamaah_data.assignment.accommodation && (
                                                <div>
                                                    <p className="text-sm font-medium">🏨 Hotel: {jamaah_data.assignment.accommodation.name}</p>
                                                    <p className="text-xs text-gray-600 dark:text-gray-400">
                                                        {jamaah_data.assignment.accommodation.location} - Room: {jamaah_data.assignment.room_number || '-'}
                                                    </p>
                                                </div>
                                            )}

                                            {jamaah_data.assignment.departure_flight && (
                                                <div>
                                                    <p className="text-sm font-medium">✈️ Penerbangan: {jamaah_data.assignment.departure_flight.flight_number}</p>
                                                    <p className="text-xs text-gray-600 dark:text-gray-400">
                                                        Seat: {jamaah_data.assignment.seat_number_departure || '-'}
                                                    </p>
                                                </div>
                                            )}
                                        </div>
                                    </div>
                                )}

                                {/* Quick Actions */}
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border">
                                    <h3 className="text-lg font-semibold mb-4">🔧 Aksi Cepat</h3>
                                    <div className="grid grid-cols-2 md:grid-cols-4 gap-4">
                                        <div className="flex flex-col items-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                            <span className="text-2xl mb-2">👤</span>
                                            <span className="text-sm text-center">Edit Profil</span>
                                        </div>
                                        <div className="flex flex-col items-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                            <span className="text-2xl mb-2">📄</span>
                                            <span className="text-sm text-center">Upload Dokumen</span>
                                        </div>
                                        <div className="flex flex-col items-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                            <span className="text-2xl mb-2">💰</span>
                                            <span className="text-sm text-center">Lihat Tagihan</span>
                                        </div>
                                        <div className="flex flex-col items-center p-4 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                            <span className="text-2xl mb-2">📞</span>
                                            <span className="text-sm text-center">Hubungi Staff</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            <div className="bg-white dark:bg-gray-800 rounded-lg p-6 shadow border text-center">
                                <div className="text-6xl mb-4">📋</div>
                                <h3 className="text-xl font-semibold mb-2">Profil Jamaah Belum Lengkap</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">
                                    Silakan hubungi staff admin untuk melengkapi data profil jamaah Anda.
                                </p>
                                <div className="inline-flex items-center px-4 py-2 bg-emerald-100 dark:bg-emerald-900/20 text-emerald-800 dark:text-emerald-200 rounded-lg">
                                    📞 Hubungi Staff Admin
                                </div>
                            </div>
                        )}
                    </div>
                )}
            </div>
        </AppLayout>
    );
}