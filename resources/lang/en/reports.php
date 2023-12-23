<?php

return [
    // Messages relatifs à la création d'un report
    'report_submitted' => [
        'title' => 'Success !',
        'description' => 'Your report has been successfully submitted.'
    ],
    'report_failed' => 'Failed to submit the report. Please try again.',

    // Messages relatifs au cooldown
    'report_cooldown' => [
        'title' => 'Please wait !',
        'description' => 'You have recently submitted a report. Please wait before submitting another one.'
    ],

    // Messages de validation
    'reportable_type_required' => 'The type of the item to be reported is required.',
    'reportable_id_required' => 'The ID of the item to be reported is required.',
    'reason_required' => 'A reason for the report is required.',

    // Autres messages possibles
    'report_not_found' => 'The requested report could not be found.',
    'report_resolved' => 'The report has been resolved.',
    'report_resolve_failed' => 'Failed to resolve the report. Please try again.',
    'unauthorized_report_access' => 'You are not authorized to access this report.',

    // Messages spécifiques pour la résolution de reports
    'resolve_message_required' => 'A resolution message is required to resolve the report.',
    'invalid_report_resolution' => 'Invalid resolution details provided.',

    // Autres messages d'erreur
    'generic_error' => 'An error occurred. Please try again later.',

    'modal_title' => 'Report :content',
    'modal_button_trigger' => 'Report Resource',
    'modal_reason_label' => 'Reason for Report',
    'modal_reason_placeholder' => 'Describe the reason for your report...',
    'modal_close_button' => 'Close',
    'modal_submit_button' => 'Submit Report',
    'abuse_warning' => 'Please note that submitting reports without a valid reason may result in sanctions. Use the report feature responsibly.',
];
