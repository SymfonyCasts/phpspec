<?php

namespace spec\Matchers;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\BasicMatcher;

final class BeGreaterMatcher extends BasicMatcher
{
    /**
     * @param mixed $subject
     * @param array $arguments
     *
     * @return boolean
     */
    protected function matches($subject, array $arguments): bool
    {
        return $subject > $arguments[0];
    }

    /**
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     *
     * @return FailureException
     */
    protected function getFailureException(string $name, $subject, array $arguments): FailureException
    {
        return new FailureException(sprintf(
            'Expected %d to be greater than %d',
            $subject,
            $arguments[0]
        ));
    }

    /**
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     *
     * @return FailureException
     */
    protected function getNegativeFailureException(string $name, $subject, array $arguments): FailureException
    {
        return new FailureException(sprintf(
            'Expected %d to not be greater than %d',
            $subject,
            $arguments[0]
        ));
    }

    /**
     * Checks if matcher supports provided subject and matcher name.
     *
     * @param string $name
     * @param mixed $subject
     * @param array $arguments
     *
     * @return Boolean
     */
    public function supports(string $name, $subject, array $arguments): bool
    {
        return \in_array($name, ['beGreater', 'beGreaterThan'], true)
            && is_numeric($subject)
            && \count($arguments) > 0
            && is_numeric($arguments[0]);
    }
}
