<?php

namespace Database\Seeders;

use App\Models\CarMake;
use App\Models\CarModel;
use Illuminate\Database\Seeder;

class CarMakesSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Alfa Romeo'    => ['147', '156', '159', 'Giulietta', 'Giulia', 'Stelvio', 'Mito', 'Tonale', '166', 'Brera', 'Spider'],
            'Audi'          => ['A1', 'A2', 'A3', 'A4', 'A5', 'A6', 'A7', 'A8', 'Q2', 'Q3', 'Q4 e-tron', 'Q5', 'Q7', 'Q8', 'TT', 'R8', 'e-tron', 'e-tron GT', 'S3', 'S4', 'S5', 'S6', 'RS3', 'RS4', 'RS6'],
            'BMW'           => ['1 Series', '2 Series', '3 Series', '4 Series', '5 Series', '6 Series', '7 Series', '8 Series', 'X1', 'X2', 'X3', 'X4', 'X5', 'X6', 'X7', 'Z4', 'i3', 'i4', 'i5', 'i7', 'iX', 'M3', 'M5', 'M8'],
            'Chevrolet'     => ['Aveo', 'Cruze', 'Spark', 'Captiva', 'Orlando', 'Camaro', 'Corvette', 'Trax'],
            'Citroën'       => ['C1', 'C2', 'C3', 'C3 Aircross', 'C4', 'C4 Cactus', 'C4 Picasso', 'C5', 'C5 Aircross', 'C5 X', 'C6', 'Berlingo', 'DS3', 'DS4', 'DS5', 'ë-C4'],
            'Cupra'         => ['Born', 'Formentor', 'Leon', 'Ateca', 'Terramar'],
            'Dacia'         => ['Duster', 'Sandero', 'Logan', 'Spring', 'Jogger', 'Dokker', 'Lodgy', 'Bigster'],
            'Fiat'          => ['500', '500X', '500L', '500e', 'Bravo', 'Punto', 'Grande Punto', 'Tipo', 'Panda', 'Doblo', 'Freemont', 'Stilo', 'Seicento', '126p'],
            'Ford'          => ['Fiesta', 'Focus', 'Mondeo', 'Kuga', 'Puma', 'EcoSport', 'Edge', 'Explorer', 'Mustang', 'Mustang Mach-E', 'Galaxy', 'S-Max', 'C-Max', 'B-Max', 'Ranger', 'Transit', 'Tourneo'],
            'Honda'         => ['Civic', 'Accord', 'CR-V', 'HR-V', 'Jazz', 'e', 'e:Ny1', 'FR-V', 'Legend', 'Insight'],
            'Hyundai'       => ['i10', 'i20', 'i30', 'i40', 'Tucson', 'Santa Fe', 'Kona', 'IONIQ', 'IONIQ 5', 'IONIQ 6', 'Nexo', 'Bayon', 'ix20', 'ix35', 'Accent'],
            'Isuzu'         => ['D-Max', 'MU-X'],
            'Jeep'          => ['Renegade', 'Compass', 'Cherokee', 'Grand Cherokee', 'Avenger', 'Wrangler', 'Gladiator'],
            'Kia'           => ['Picanto', 'Rio', 'Ceed', 'ProCeed', 'Proceed', 'Stonic', 'Sportage', 'Sorento', 'Niro', 'EV6', 'EV9', 'XCeed', 'Soul', 'Carnival'],
            'Lada'          => ['2101', '2105', '2107', '2108', '2109', 'Niva', 'Granta', 'Vesta', 'XRAY', 'Largus'],
            'Land Rover'    => ['Defender', 'Discovery', 'Discovery Sport', 'Freelander', 'Range Rover', 'Range Rover Sport', 'Range Rover Evoque', 'Range Rover Velar'],
            'Lexus'         => ['IS', 'ES', 'NX', 'RX', 'UX', 'CT', 'GS', 'LS', 'LC', 'LBX'],
            'Mazda'         => ['Mazda2', 'Mazda3', 'Mazda6', 'CX-3', 'CX-30', 'CX-5', 'CX-60', 'CX-90', 'MX-5', 'MX-30'],
            'Mercedes-Benz' => ['A-Class', 'B-Class', 'C-Class', 'E-Class', 'S-Class', 'CLA', 'CLS', 'GLA', 'GLB', 'GLC', 'GLE', 'GLS', 'EQA', 'EQB', 'EQC', 'EQE', 'EQS', 'V-Class', 'AMG GT', 'SL', 'G-Class'],
            'MG'            => ['3', 'ZS', 'HS', 'RX5', '4', '5', 'Cyberster'],
            'MINI'          => ['Cooper', 'Cooper S', 'Clubman', 'Countryman', 'Paceman', 'Convertible', 'Aceman', 'Electric'],
            'Mitsubishi'    => ['Colt', 'Lancer', 'ASX', 'Eclipse Cross', 'Outlander', 'L200', 'Space Star', 'Galant'],
            'Nissan'        => ['Micra', 'Note', 'Juke', 'Qashqai', 'X-Trail', 'Leaf', 'Ariya', 'Navara', 'Pulsar', 'Almera', 'Patrol', '350Z', '370Z'],
            'Opel'          => ['Agila', 'Astra', 'Corsa', 'Insignia', 'Mokka', 'Crossland', 'Grandland', 'Meriva', 'Zafira', 'Vectra', 'Omega', 'Antara', 'Adam', 'Karl', 'Cascada'],
            'Peugeot'       => ['107', '108', '205', '206', '207', '208', '301', '308', '408', '508', '2008', '3008', '4008', '5008', 'Rifter', 'Partner', 'Expert'],
            'Porsche'       => ['911', 'Cayenne', 'Macan', 'Panamera', 'Taycan', 'Boxster', 'Cayman'],
            'Renault'       => ['Clio', 'Megane', 'Laguna', 'Scenic', 'Espace', 'Kadjar', 'Captur', 'Koleos', 'Fluence', 'Zoe', 'Twingo', 'Talisman', 'Arkana', 'Austral', 'Kangoo'],
            'Seat'          => ['Ibiza', 'Leon', 'Arona', 'Ateca', 'Tarraco', 'Mii', 'Toledo', 'Alhambra', 'Exeo'],
            'Škoda'         => ['Fabia', 'Rapid', 'Scala', 'Octavia', 'Superb', 'Karoq', 'Kodiaq', 'Kamiq', 'Enyaq', 'Citigo', 'Yeti', 'Roomster', 'Octavia RS'],
            'Subaru'        => ['Impreza', 'Legacy', 'Outback', 'Forester', 'XV', 'Crosstrek', 'WRX', 'BRZ', 'Solterra'],
            'Suzuki'        => ['Alto', 'Swift', 'Splash', 'Celerio', 'Baleno', 'Vitara', 'SX4', 'SX4 S-Cross', 'Jimny', 'Ignis', 'Across'],
            'Tesla'         => ['Model S', 'Model 3', 'Model X', 'Model Y', 'Cybertruck', 'Roadster'],
            'Toyota'        => ['Aygo', 'Aygo X', 'Yaris', 'Yaris Cross', 'Corolla', 'Camry', 'Avensis', 'Auris', 'RAV4', 'C-HR', 'Highlander', 'Land Cruiser', 'Prius', 'bZ4X', 'Hilux', 'Proace', 'GR86', 'Supra'],
            'Volkswagen'    => ['Polo', 'Golf', 'Golf Plus', 'Golf Sportsvan', 'Passat', 'Arteon', 'Tiguan', 'Touareg', 'T-Roc', 'T-Cross', 'Taos', 'ID.3', 'ID.4', 'ID.5', 'ID.7', 'Sharan', 'Touran', 'Caddy', 'Amarok', 'Transporter', 'Jetta'],
            'Volvo'         => ['C30', 'C40', 'S40', 'S60', 'S80', 'S90', 'V40', 'V50', 'V60', 'V70', 'V90', 'XC40', 'XC60', 'XC70', 'XC90', 'EX30', 'EX40', 'EX90'],
        ];

        foreach ($data as $makeName => $modelNames) {
            $make = CarMake::firstOrCreate(['name' => $makeName], ['is_active' => true]);
            foreach ($modelNames as $modelName) {
                CarModel::firstOrCreate(
                    ['car_make_id' => $make->id, 'name' => $modelName],
                    ['is_active' => true]
                );
            }
        }
    }
}
