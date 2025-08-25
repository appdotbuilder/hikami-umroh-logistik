import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

interface Props {
    stats?: {
        total_jamaah: number;
        total_packages: number;
        active_packages: number;
        pending_payments: number;
        pending_documents: number;
        available_equipment: number;
    };
    recent_packages?: Array<{
        id: number;
        name: string;
        departure_date: string;
        price: string;
        capacity: number;
        registered_count: number;
        status: string;
    }>;
    upcoming_departures?: Array<{
        id: number;
        name: string;
        departure_date: string;
        registered_count: number;
        capacity: number;
    }>;
    [key: string]: unknown;
}

export default function Welcome({ stats, recent_packages, upcoming_departures }: Props) {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="PT Hikami Mandiri Indonesia - Sistem Manajemen Logistik Umroh">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
                {/* Navigation */}
                <nav className="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-sm border-b border-gray-200/50 dark:bg-gray-900/90 dark:border-gray-700/50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center">
                                <span className="text-2xl font-bold text-emerald-600">🕌</span>
                                <span className="ml-2 text-xl font-bold text-gray-900 dark:text-white">PT Hikami Mandiri</span>
                            </div>
                            <div className="flex items-center space-x-4">
                                {auth.user ? (
                                    <Link
                                        href={route('dashboard')}
                                        className="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-colors"
                                    >
                                        Dashboard
                                    </Link>
                                ) : (
                                    <>
                                        <Link
                                            href={route('login')}
                                            className="px-4 py-2 text-gray-700 hover:text-emerald-600 transition-colors dark:text-gray-300"
                                        >
                                            Masuk
                                        </Link>
                                        <Link
                                            href={route('register')}
                                            className="px-6 py-2 bg-emerald-600 text-white rounded-lg font-semibold hover:bg-emerald-700 transition-colors"
                                        >
                                            Daftar
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </nav>

                {/* Hero Section */}
                <section className="pt-24 pb-16 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto text-center">
                        <div className="mb-8">
                            <h1 className="text-5xl sm:text-6xl font-bold text-gray-900 dark:text-white mb-6">
                                🕋 <span className="text-emerald-600">Sistem Manajemen</span><br />
                                Logistik Umroh Terpadu
                            </h1>
                            <p className="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                                Solusi lengkap untuk mengelola perjalanan ibadah umroh dengan sistem terintegrasi 
                                dari pendaftaran hingga kepulangan jamaah
                            </p>
                        </div>

                        {/* Stats Overview */}
                        {stats && (
                            <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-12">
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div className="text-2xl font-bold text-emerald-600">{stats.total_jamaah}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">👥 Total Jamaah</div>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div className="text-2xl font-bold text-blue-600">{stats.total_packages}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">📦 Paket Travel</div>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div className="text-2xl font-bold text-green-600">{stats.active_packages}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">✅ Paket Aktif</div>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div className="text-2xl font-bold text-orange-600">{stats.pending_payments}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">💰 Pembayaran Tertunda</div>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div className="text-2xl font-bold text-purple-600">{stats.pending_documents}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">📄 Dokumen Pending</div>
                                </div>
                                <div className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div className="text-2xl font-bold text-indigo-600">{stats.available_equipment}</div>
                                    <div className="text-sm text-gray-600 dark:text-gray-400">🎒 Perlengkapan Tersedia</div>
                                </div>
                            </div>
                        )}
                    </div>
                </section>

                {/* Features Section */}
                <section className="py-16 bg-white/50 dark:bg-gray-800/50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="text-center mb-12">
                            <h2 className="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                                ✨ Fitur Lengkap untuk Semua Kebutuhan
                            </h2>
                            <p className="text-gray-600 dark:text-gray-300">
                                Sistem yang dirancang khusus untuk memudahkan pengelolaan perjalanan umroh
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-3xl mb-4">👥</div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Manajemen User</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">Kelola akun Superadmin, Staff Admin, dan Jamaah dengan sistem role-based access control</p>
                                <div className="text-sm text-emerald-600 font-medium">• CRUD Pengguna • Manajemen Role • Kontrol Akses</div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-3xl mb-4">📋</div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Data Jamaah</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">Pengelolaan data pribadi jamaah, kontak darurat, dan pengaitan dengan paket perjalanan</p>
                                <div className="text-sm text-blue-600 font-medium">• Profil Lengkap • Kontak Darurat • Assignment Paket</div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-3xl mb-4">📄</div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Manajemen Dokumen</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">Upload dan verifikasi dokumen penting seperti paspor, visa, KTP, dan surat vaksinasi</p>
                                <div className="text-sm text-purple-600 font-medium">• Upload File • Status Verifikasi • Tracking Expired</div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-3xl mb-4">🎒</div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Distribusi Perlengkapan</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">Pencatatan dan tracking distribusi perlengkapan umroh seperti koper, seragam, dan tas</p>
                                <div className="text-sm text-orange-600 font-medium">• Inventory Management • Distribution Tracking • Stock Control</div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-3xl mb-4">✈️</div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Transportasi & Akomodasi</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">Pengaturan tiket pesawat, hotel di Mekkah-Madinah, dan transportasi lokal</p>
                                <div className="text-sm text-indigo-600 font-medium">• Flight Booking • Hotel Management • Local Transport</div>
                            </div>

                            <div className="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                                <div className="text-3xl mb-4">💰</div>
                                <h3 className="text-xl font-semibold text-gray-900 dark:text-white mb-3">Keuangan & Laporan</h3>
                                <p className="text-gray-600 dark:text-gray-400 mb-4">Tracking pembayaran jamaah, pengeluaran, dan laporan keuangan komprehensif</p>
                                <div className="text-sm text-green-600 font-medium">• Payment Tracking • Financial Reports • Invoice Management</div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Recent Packages & Upcoming Departures */}
                {(recent_packages && recent_packages.length > 0) || (upcoming_departures && upcoming_departures.length > 0) ? (
                    <section className="py-16">
                        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                                {/* Recent Packages */}
                                {recent_packages && recent_packages.length > 0 && (
                                    <div>
                                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">📦 Paket Terbaru</h2>
                                        <div className="space-y-4">
                                            {recent_packages.map((pkg) => (
                                                <div key={pkg.id} className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border border-gray-200 dark:border-gray-700">
                                                    <div className="flex justify-between items-start">
                                                        <div>
                                                            <h3 className="font-semibold text-gray-900 dark:text-white">{pkg.name}</h3>
                                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                                Keberangkatan: {new Date(pkg.departure_date).toLocaleDateString('id-ID')}
                                                            </p>
                                                        </div>
                                                        <div className="text-right">
                                                            <div className="font-bold text-emerald-600">
                                                                {new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(parseFloat(pkg.price))}
                                                            </div>
                                                            <div className="text-sm text-gray-600 dark:text-gray-400">
                                                                {pkg.registered_count}/{pkg.capacity} jamaah
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                )}

                                {/* Upcoming Departures */}
                                {upcoming_departures && upcoming_departures.length > 0 && (
                                    <div>
                                        <h2 className="text-2xl font-bold text-gray-900 dark:text-white mb-6">🚀 Keberangkatan Mendatang</h2>
                                        <div className="space-y-4">
                                            {upcoming_departures.map((departure) => (
                                                <div key={departure.id} className="bg-white dark:bg-gray-800 rounded-lg p-4 shadow border border-gray-200 dark:border-gray-700">
                                                    <div className="flex justify-between items-center">
                                                        <div>
                                                            <h3 className="font-semibold text-gray-900 dark:text-white">{departure.name}</h3>
                                                            <p className="text-sm text-gray-600 dark:text-gray-400">
                                                                {new Date(departure.departure_date).toLocaleDateString('id-ID', {
                                                                    weekday: 'long',
                                                                    year: 'numeric',
                                                                    month: 'long',
                                                                    day: 'numeric'
                                                                })}
                                                            </p>
                                                        </div>
                                                        <div className="text-right">
                                                            <div className="text-sm font-medium text-blue-600">
                                                                {departure.registered_count}/{departure.capacity} jamaah
                                                            </div>
                                                            <div className="text-xs text-gray-500">
                                                                {Math.ceil((new Date(departure.departure_date).getTime() - new Date().getTime()) / (1000 * 60 * 60 * 24))} hari lagi
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </section>
                ) : null}

                {/* CTA Section */}
                <section className="py-16 bg-gradient-to-r from-emerald-600 to-blue-600">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                        <h2 className="text-3xl font-bold text-white mb-6">
                            🚀 Siap Memulai Perjalanan Digital Anda?
                        </h2>
                        <p className="text-xl text-emerald-100 mb-8 max-w-2xl mx-auto">
                            Bergabunglah dengan sistem manajemen logistik umroh yang telah dipercaya 
                            untuk mengelola ribuan jamaah
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            {!auth.user && (
                                <>
                                    <Link
                                        href={route('register')}
                                        className="px-8 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
                                    >
                                        Daftar Sekarang
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-emerald-600 transition-colors"
                                    >
                                        Masuk ke Sistem
                                    </Link>
                                </>
                            )}
                            {auth.user && (
                                <Link
                                    href={route('dashboard')}
                                    className="px-8 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors"
                                >
                                    Akses Dashboard
                                </Link>
                            )}
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-12">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <div className="flex items-center mb-4">
                                    <span className="text-2xl">🕌</span>
                                    <span className="ml-2 text-xl font-bold">PT Hikami Mandiri Indonesia</span>
                                </div>
                                <p className="text-gray-400">
                                    Penyelenggara perjalanan ibadah umroh terpercaya dengan sistem manajemen logistik modern.
                                </p>
                            </div>
                            <div>
                                <h3 className="text-lg font-semibold mb-4">Fitur Utama</h3>
                                <ul className="space-y-2 text-gray-400">
                                    <li>• Manajemen Data Jamaah</li>
                                    <li>• Tracking Dokumen</li>
                                    <li>• Distribusi Perlengkapan</li>
                                    <li>• Monitoring Keuangan</li>
                                </ul>
                            </div>
                            <div>
                                <h3 className="text-lg font-semibold mb-4">Peran Pengguna</h3>
                                <ul className="space-y-2 text-gray-400">
                                    <li>👑 Superadmin - Kontrol Penuh</li>
                                    <li>👨‍💼 Staff Admin - Operasional</li>
                                    <li>🕋 Jamaah - Self Service</li>
                                </ul>
                            </div>
                        </div>
                        <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                            <p>&copy; 2024 PT Hikami Mandiri Indonesia. Sistem Manajemen Logistik Umroh Terpadu.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}