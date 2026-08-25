<table>
    <thead>

        {{-- =====================================================
             JUDUL
        ====================================================== --}}

        <tr>
            <th colspan="18"
                style="
                    font-size:18px;
                    font-weight:bold;
                    text-align:center;
                ">
                GENERASI ZENIUS INSPIRATIF
            </th>
        </tr>

        <tr>
            <th colspan="18"
                style="
                    font-size:14px;
                    font-weight:bold;
                    text-align:center;
                ">
                DATA SISWA
            </th>
        </tr>

        <tr>
            <th colspan="18"></th>
        </tr>


        {{-- =====================================================
             FILTER
        ====================================================== --}}

        <tr>
            <th colspan="3">
                Filter
            </th>

            <th colspan="15">
                Data berdasarkan filter yang digunakan
            </th>
        </tr>

        <tr>
            <th colspan="3">
                Lokasi
            </th>

            <th colspan="15">
                {{ $filterLocation ?? 'Semua Lokasi' }}
            </th>
        </tr>

        <tr>
            <th colspan="3">
                Kelas
            </th>

            <th colspan="15">
                {{ $filterKelas ?? 'Semua Kelas' }}
            </th>
        </tr>

        <tr>
            <th colspan="3">
                Group Kelas
            </th>

            <th colspan="15">
                {{ $filterClassGroup ?? 'Semua Group Kelas' }}
            </th>
        </tr>

        <tr>
            <th colspan="3">
                Sekolah
            </th>

            <th colspan="15">
                {{ $filterSchool ?? 'Semua Sekolah' }}
            </th>
        </tr>

        <tr>
            <th colspan="3">
                Tanggal Pendaftaran
            </th>

            <th colspan="15">
                {{ $filterDate ?? 'Semua Tanggal' }}
            </th>
        </tr>

        <tr>
            <th colspan="18"></th>
        </tr>


        {{-- =====================================================
             HEADER DATA
        ====================================================== --}}

        <tr>
            <th style="border:1px solid #000;">No</th>
            <th style="border:1px solid #000;">ID</th>
            <th style="border:1px solid #000;">Nama Siswa</th>
            <th style="border:1px solid #000;">Version</th>
            <th style="border:1px solid #000;">Status</th>
            <th style="border:1px solid #000;">Tanggal Pendaftaran</th>
            <th style="border:1px solid #000;">Lama</th>
            <th style="border:1px solid #000;">Quiz Score</th>
            <th style="border:1px solid #000;">Bank Soal Score</th>
            <th style="border:1px solid #000;">Lokasi</th>
            <th style="border:1px solid #000;">NIS</th>
            <th style="border:1px solid #000;">Kelas</th>
            <th style="border:1px solid #000;">Group Kelas</th>
            <th style="border:1px solid #000;">HP Ayah</th>
            <th style="border:1px solid #000;">HP Ibu</th>
            <th style="border:1px solid #000;">Sekolah</th>
            <th style="border:1px solid #000;">Email</th>
            <th style="border:1px solid #000;">Telepon</th>
        </tr>

    </thead>

    <tbody>

        @foreach($siswa as $index => $item)

            @php

                /*
                |--------------------------------------------------------------------------
                | LAMA
                |--------------------------------------------------------------------------
                */

                $lama = '-';

                if ($item->created_at) {

                    $diff = $item->created_at->diff(now());

                    $hasil = [];

                    if ($diff->y > 0) {
                        $hasil[] = $diff->y . ' tahun';
                    }

                    if ($diff->m > 0) {
                        $hasil[] = $diff->m . ' bulan';
                    }

                    if ($diff->d > 0) {
                        $hasil[] = $diff->d . ' hari';
                    }

                    $lama = count($hasil)
                        ? implode(' ', $hasil)
                        : 'Hari ini';
                }

                /*
                |--------------------------------------------------------------------------
                | SCORE
                |--------------------------------------------------------------------------
                */

                $quizScore = $quizScores->get(
                    $item->id,
                    0
                );

                $bankScore = $bankScores->get(
                    $item->id,
                    0
                );

            @endphp

           <tr>

                <td style="border:1px solid #000;">
                    {{ $index + 1 }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->id }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->name }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->version ?: '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->is_active == 1 ? 'Active' : 'Inactive' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->created_at
                        ? $item->created_at->format('d-m-Y')
                        : '-'
                    }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $lama }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $quizScore }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $bankScore }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->location->name ?? '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->nis ?: '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->kelas->nama_kelas ?? '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->class_group ?: '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->fathers_phone ?: '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->mothers_phone ?: '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->school->school_name ?? '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->email ?: '-' }}
                </td>
            
                <td style="border:1px solid #000;">
                    {{ $item->phone ?: '-' }}
                </td>
            
            </tr>

        @endforeach

    </tbody>
</table>