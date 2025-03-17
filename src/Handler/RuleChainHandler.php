<?php

namespace App\Handler;

use App\Entity\RedirectRule;

class RuleChainHandler
{
    /**
     * @param iterable<RuleHandlerInterface> $handlers
     */
    public function __construct(
        private iterable $handlers,
    ) {
    }

    public function process(RedirectRule $redirectRule, RuleContext $context): ?string
    {
        // Проверяем, что ВСЕ правила в коллекции $rules удовлетворяют условиям
        foreach ($redirectRule->getRules() as $rule) {
            $ruleSatisfied = false;

            // Проверяем правило с помощью подходящего обработчика
            foreach ($this->handlers as $handler) {
                if ($handler->supports($rule)) {
                    $result = $handler->handle($rule, $context);
                    if ($result) {
                        $ruleSatisfied = true;
                        break; // Правило удовлетворено, переходим к следующему
                    }
                }
            }

            // Если хотя бы одно правило не удовлетворено, возвращаем null
            if (!$ruleSatisfied) {
                return null;
            }
        }

        // Все правила удовлетворены, возвращаем URL для редиректа
        return $redirectRule->getRedirectUrl();
    }
}