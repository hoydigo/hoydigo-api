<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PoliticalPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::table('political_positions')->insert([
                'id' => 'DEX',
                'name' => 'Extrema Derecha',
                'description' => 'Extrema derecha, derecha radical o ultraderecha son términos utilizados en política para describir movimientos o partidos políticos que promueven y sostienen posiciones o discursos nacionalistas, patriotistas o ultraconservadores considerados radicales o extremistas. Estas posturas radicales corrientemente se vinculan con prácticas antidemocráticas.',
            ]);
            DB::table('political_positions')->insert([
                'id' => 'DER',
                'name' => 'Derecha',
                'description' => 'Derecha es un tipo de pensamiento político que prioriza la conservación del orden como política fundamental de cualquier gestión de gobierno. Pero la derecha tiene más definiciones que la caracterizan como tal y entonces a lo expuesto debemos sumar: la defensa de la libertad individual, de la propiedad privada, del libre mercado, entre las más destacadas.',
            ]);
            DB::table('political_positions')->insert([
                'id' => 'DCE',
                'name' => 'Centroderecha',
                'description' => 'La centroderecha comprende a las personas u organizaciones que comparten ideologías de derecha y del centro o un intermedio entre ambas. En la práctica política el término es generalmente usado en varios sentidos. Por ejemplo, se ha aplicado a la alianza ocasional de sectores políticos de centro y de derecha. Aquí se entenderá como se ha delineado al principio a sí mismo la derecha hace referencia al liberalismo económico y políticas a favor del comercio.',
            ]);
            DB::table('political_positions')->insert([
                'id' => 'CEN',
                'name' => 'Centro',
                'description' => 'Se conoce por centro al conjunto de partidos, políticas e ideologías, que se caracteriza por considerarse a sí mismo en el espectro político, como intermedio o como árbitro de posiciones antagónicas tanto de derecha como de izquierda.',
            ]);
            DB::table('political_positions')->insert([
                'id' => 'ICE',
                'name' => 'Centroizquierda',
                'description' => 'Se denomina centroizquierda al espectro político donde se ubica a formaciones políticas comprendidas entre el centro y la izquierda revolucionaria o rupturista. La centroizquierda por lo tanto se contrapone no solo a la derecha sino también a dichos posicionamientos de extrema izquierda. Las ideologías típicas de centro izquierda serían el progresismo, el socioliberalismo y el socialismo democrático. ',
            ]);
            DB::table('political_positions')->insert([
                'id' => 'IZQ',
                'name' => 'Izquierda',
                'description' => 'La izquierda es el sector del espectro político que defiende la igualdad social y el igualitarismo, frecuentemente en contraposición a las jerarquías entre individuos. El término izquierda se utilizó por primera vez para referirse al republicanismo, el renacimiento de la democracia durante la Revolución francesa y el liberalismo clásico. Después comenzó a aplicarse al socialismo, el comunismo, la socialdemocracia y varias formas de anarquismo. También se asocia a los movimientos por los derechos civiles, el movimiento contra la guerra y al ecologismo. ',
            ]);
            DB::table('political_positions')->insert([
                'id' => 'IEX',
                'name' => 'Extrema Izquierda',
                'description' => 'Extrema izquierda o ultraizquierda son términos utilizados en política para definir al conjunto de movimientos, ideologías y partidos políticos que promueven sistemas sociales y económicos más a la izquierda que la izquierda política estándar. El término se ha usado para describir ideologías como el anarquismo, el anarcocomunismo o el maoísmo entre otros. Aunque entre las teorías hay un abismo de matices como la conservación del individualismo por parte del anarquismo en contraposición al colectivismo teorizado por el resto.',
            ]);

        } catch (\Throwable $e) {
            Log::error(
                'Political Positions Seeder, ' .
                'error: ' . $e->getMessage()
            );
        }

    }
}
