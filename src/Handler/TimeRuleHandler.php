<?php

namespace App\Handler;

use App\Entity\Rule;
use App\Entity\TimeRule;
use DateTime;
use DateTimeZone;

class TimeRuleHandler implements RuleHandlerInterface
{
    public function supports(Rule $rule): bool
    {
        return $rule instanceof TimeRule;
    }

    public function handle(Rule $rule, RuleContext $context): ?string
    {
        /** @var TimeRule $timeRule */
        $timeRule = $rule;

        $userTime = $this->getUserTime($context);

        $startTime = $this->convertToUserTimezone($timeRule->getStartTime(), $context->getTimezone());
        $endTime = $this->convertToUserTimezone($timeRule->getEndTime(), $context->getTimezone());

        // Проверяем, попадает ли текущее время пользователя в интервал
        if ($userTime >= $startTime && $userTime <= $endTime) {
            return $timeRule->getRedirectRule()->getRedirectUrl();
        }

        return null;
    }

    /**
     * Получает текущее время пользователя с учётом его часового пояса.
     */
    private function getUserTime(RuleContext $context): DateTime
    {
        // Если часовой пояс пользователя передан в контексте, используем его
        $timezone = $context->getTimezone() ?? 'UTC';

        // Получаем текущее время в часовом поясе пользователя
        return new DateTime('now', new DateTimeZone($timezone));
    }

    /**
     * Преобразует время из базы данных (UTC) в часовой пояс пользователя.
     */
    private function convertToUserTimezone(DateTime $time, string $userTimezone): DateTime
    {
        $convertedTime = clone $time;
        $convertedTime->setTimezone(new DateTimeZone($userTimezone));

        return $convertedTime;
    }
}