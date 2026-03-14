<?php

namespace App\Helpers;

enum PaymentStatus: string {
	case PROCESSING = 'processing';

    case SUCCESS = 'success';

    case FAILURE = 'failure';
}