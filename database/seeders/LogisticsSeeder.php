<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jamaah;
use App\Models\TravelPackage;
use App\Models\Equipment;
use App\Models\Accommodation;
use App\Models\Flight;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LogisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin users
        $superadmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@hikami.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'phone' => '081234567890',
            'address' => 'Jakarta, Indonesia',
            'is_active' => true,
        ]);

        $staffadmin = User::create([
            'name' => 'Staff Administrator',
            'email' => 'staff@hikami.com',
            'password' => Hash::make('password'),
            'role' => 'staffadmin',
            'phone' => '081234567891',
            'address' => 'Jakarta, Indonesia',
            'is_active' => true,
        ]);

        // Create jamaah user with profile
        $jamaahUser = User::create([
            'name' => 'Ahmad Jamaah',
            'email' => 'jamaah@hikami.com',
            'password' => Hash::make('password'),
            'role' => 'jamaah',
            'phone' => '081234567892',
            'address' => 'Bandung, Indonesia',
            'is_active' => true,
        ]);

        $jamaah = Jamaah::create([
            'user_id' => $jamaahUser->id,
            'nik' => '3273010101900001',
            'full_name' => 'Ahmad Jamaah',
            'gender' => 'male',
            'place_of_birth' => 'Bandung',
            'date_of_birth' => '1990-01-01',
            'nationality' => 'Indonesia',
            'occupation' => 'Entrepreneur',
            'emergency_contact_name' => 'Fatimah Ahmad',
            'emergency_contact_phone' => '081234567893',
            'medical_notes' => null,
            'status' => 'registered',
        ]);

        // Create travel packages
        $packages = TravelPackage::factory(5)->create();
        
        // Create additional jamaah
        Jamaah::factory(15)->create();

        // Create equipment
        $equipmentTypes = [
            ['name' => 'Koper Umroh', 'description' => 'Koper ukuran besar untuk perjalanan umroh', 'stock_quantity' => 100, 'distributed_quantity' => 25],
            ['name' => 'Tas Tenteng', 'description' => 'Tas tenteng untuk keperluan sehari-hari', 'stock_quantity' => 200, 'distributed_quantity' => 50],
            ['name' => 'Seragam Ihram Pria', 'description' => 'Pakaian ihram untuk jamaah pria', 'stock_quantity' => 150, 'distributed_quantity' => 30],
            ['name' => 'Mukena Wanita', 'description' => 'Mukena untuk jamaah wanita', 'stock_quantity' => 120, 'distributed_quantity' => 35],
            ['name' => 'Sajadah Portable', 'description' => 'Sajadah portable untuk sholat', 'stock_quantity' => 300, 'distributed_quantity' => 75],
            ['name' => 'Sandal Umroh', 'description' => 'Sandal untuk perjalanan umroh', 'stock_quantity' => 180, 'distributed_quantity' => 40],
            ['name' => 'Tas Pinggang', 'description' => 'Tas pinggang untuk dokumen penting', 'stock_quantity' => 80, 'distributed_quantity' => 15],
            ['name' => 'Tasbih', 'description' => 'Tasbih untuk dzikir', 'stock_quantity' => 500, 'distributed_quantity' => 100],
        ];

        foreach ($equipmentTypes as $equipment) {
            Equipment::create($equipment + ['status' => 'available']);
        }

        // Create accommodations
        $accommodations = [
            [
                'name' => 'Hotel Madinah Palace',
                'type' => 'hotel',
                'location' => 'madinah',
                'address' => 'King Abdul Aziz Road, Madinah',
                'star_rating' => 5,
                'facilities' => 'AC, WiFi, Breakfast, Airport Shuttle',
                'distance_to_haram' => 0.5,
            ],
            [
                'name' => 'Makkah Residence',
                'type' => 'apartment',
                'location' => 'makkah',
                'address' => 'Ajyad Street, Makkah',
                'star_rating' => 4,
                'facilities' => 'AC, WiFi, Kitchenette, Laundry',
                'distance_to_haram' => 0.3,
            ],
            [
                'name' => 'Al Kiswah Hotel',
                'type' => 'hotel',
                'location' => 'makkah',
                'address' => 'Ibrahim Al Khalil Street, Makkah',
                'star_rating' => 4,
                'facilities' => 'AC, WiFi, Breakfast, Prayer Hall',
                'distance_to_haram' => 0.8,
            ],
        ];

        foreach ($accommodations as $accommodation) {
            Accommodation::create($accommodation);
        }

        // Create flights
        $flights = [
            [
                'flight_number' => 'GA-900',
                'airline' => 'Garuda Indonesia',
                'departure_airport' => 'CGK',
                'arrival_airport' => 'JED',
                'departure_time' => '2024-03-15 08:00:00',
                'arrival_time' => '2024-03-15 14:30:00',
                'type' => 'departure',
                'status' => 'scheduled',
            ],
            [
                'flight_number' => 'GA-901',
                'airline' => 'Garuda Indonesia',
                'departure_airport' => 'JED',
                'arrival_airport' => 'CGK',
                'departure_time' => '2024-03-28 16:00:00',
                'arrival_time' => '2024-03-29 06:30:00',
                'type' => 'return',
                'status' => 'scheduled',
            ],
            [
                'flight_number' => 'SV-820',
                'airline' => 'Saudi Airlines',
                'departure_airport' => 'CGK',
                'arrival_airport' => 'JED',
                'departure_time' => '2024-04-10 10:30:00',
                'arrival_time' => '2024-04-10 17:00:00',
                'type' => 'departure',
                'status' => 'scheduled',
            ],
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }

        // Create sample payments
        $firstPackage = $packages->first();
        if ($firstPackage) {
            Payment::create([
                'jamaah_id' => $jamaah->id,
                'travel_package_id' => $firstPackage->id,
                'invoice_number' => 'INV-2024-001',
                'amount' => 5000000.00,
                'payment_method' => 'bank_transfer',
                'status' => 'paid',
                'due_date' => now()->subDays(30),
                'paid_at' => now()->subDays(28),
                'notes' => 'Pembayaran DP paket umroh',
                'recorded_by' => $staffadmin->id,
            ]);

            Payment::create([
                'jamaah_id' => $jamaah->id,
                'travel_package_id' => $firstPackage->id,
                'invoice_number' => 'INV-2024-002',
                'amount' => 10000000.00,
                'payment_method' => 'installment',
                'status' => 'pending',
                'due_date' => now()->addDays(15),
                'notes' => 'Pembayaran pelunasan paket umroh',
                'recorded_by' => $staffadmin->id,
            ]);
        }
    }
}