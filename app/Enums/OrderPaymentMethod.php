<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class OrderPaymentMethod extends Enum
{
    const CREDIT_CARD = 'credit_card';
    const DOCOMO = 'docomo';
    const AU = 'au';
    const SOFTBANK = 'softbank';
    const LINE_PAY = 'line_pay';

    public static function getDescription(mixed $value): string
    {
        return match ($value) {
            self::CREDIT_CARD => 'クレジットカード',
            self::DOCOMO => 'docomoケータイ払い',
            self::AU => 'auかんたん決済',
            self::SOFTBANK => 'ソフトバンクまとめて支払い・ワイモバイルまとめて支払い',
            self::LINE_PAY => 'LINE Pay',
        };
    }

    public function getSbpsPayMethod()
    {
        return match ($this->value) {
            self::CREDIT_CARD => 'credit3d2',
            self::DOCOMO => 'docomo',
            self::AU => 'auone',
            self::SOFTBANK => 'softbank2',
            self::LINE_PAY => 'linepay',
        };
    }
}
