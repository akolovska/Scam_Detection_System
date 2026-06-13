<?php

namespace App\Enums;

enum SourceType : string
{
    case SMS = 'sms';
    case EMAIL = 'email';
    case SOCIAL_MEDIA = 'social_media';
    case WEBSITE = 'website';
}
