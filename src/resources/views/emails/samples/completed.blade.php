<x-mail::message>
# Analysis Completed

The laboratory analysis for your sample **{{ $sample->sample_number }}** (Batch: {{ $sample->batch_number }}) is now complete.

<x-mail::panel>
**Product:** {{ $sample->product->name }}<br>
**Status:** {{ strtoupper($sample->status) }}
</x-mail::panel>

You can view and download your official Certificate of Analysis (CoA) via the secure link below:

<x-mail::button :url="$url">
Verify & Download Certificate
</x-mail::button>

Thank you for choosing **Vesper LIMS**.

Regards,<br>
{{ config('app.name') }} Laboratory Team
</x-mail::message>
