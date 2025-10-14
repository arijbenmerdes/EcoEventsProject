<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Event::select('id','title','description','start_date','end_date','location','participants_count')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Titre', 'Description', 'Début', 'Fin', 'Lieu', 'Participants'];
    }
}
