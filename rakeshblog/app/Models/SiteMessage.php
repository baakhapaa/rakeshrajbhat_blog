<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SiteMessage extends Model
{
    use SoftDeletes;
    public const CHANNEL_CONTACT = 'contact';

    public const CHANNEL_WORK = 'work';

    protected $fillable = [
        'channel',
        'name',
        'email',
        'phone',
        'subject',
        'details',
        'read_at',
    ];

    protected $casts = [
        'details' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * @return list<array{label: string, value: string}>
     */
    public function detailRows(): array
    {
        $labels = [
            'phone' => 'Phone',
            'message' => 'Message',
            'org_name' => 'Organization',
            'district' => 'District',
            'interest' => 'Interest',
            'audience' => 'Audience',
            'participants' => 'Participants',
            'preferred_date' => 'Preferred date',
            'requirements' => 'Requirements',
            'target_audience' => 'Target audience',
            'age_grade' => 'Age or grade',
            'investor_type' => 'Interest type',
            'exploration' => 'What they want to explore',
            'website' => 'Website',
            'collaboration_type' => 'Collaboration',
            'details' => 'Details',
            'location' => 'Location',
            'skills' => 'Skills',
            'portfolio' => 'Portfolio',
            'contribution_reason' => 'Why they want to contribute',
        ];

        $rows = [];

        foreach ($this->details ?? [] as $key => $value) {
            if (in_array($key, ['name', 'email', 'type_label'], true)) {
                continue;
            }

            $text = trim((string) $value);
            if ($text === '') {
                continue;
            }

            $rows[] = [
                'label' => $labels[$key] ?? Str::headline((string) $key),
                'value' => $text,
            ];
        }

        return $rows;
    }
}
