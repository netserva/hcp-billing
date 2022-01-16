<?php

declare(strict_types=1);

namespace Twilio;

class Stream implements \Iterator
{
    public $page;
    public $firstPage;
    public $limit;
    public $currentRecord;
    public $pageLimit;
    public $currentPage;

    public function __construct(Page $page, $limit, $pageLimit)
    {
        $this->page = $page;
        $this->firstPage = $page;
        $this->limit = $limit;
        $this->currentRecord = 1;
        $this->pageLimit = $pageLimit;
        $this->currentPage = 1;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element.
     *
     * @see http://php.net/manual/en/iterator.current.php
     *
     * @return mixed can return any type
     */
    public function current()
    {
        return $this->page->current();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element.
     *
     * @see http://php.net/manual/en/iterator.next.php
     */
    public function next(): void
    {
        $this->page->next();
        ++$this->currentRecord;

        if ($this->overLimit()) {
            return;
        }

        if (!$this->page->valid()) {
            if ($this->overPageLimit()) {
                return;
            }
            $this->page = $this->page->nextPage();
            ++$this->currentPage;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element.
     *
     * @see http://php.net/manual/en/iterator.key.php
     *
     * @return mixed scalar on success, or null on failure
     */
    public function key()
    {
        return $this->currentRecord;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid.
     *
     * @see http://php.net/manual/en/iterator.valid.php
     *
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     */
    public function valid(): bool
    {
        return $this->page && $this->page->valid() && !$this->overLimit() && !$this->overPageLimit();
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element.
     *
     * @see http://php.net/manual/en/iterator.rewind.php
     */
    public function rewind(): void
    {
        $this->page = $this->firstPage;
        $this->page->rewind();
        $this->currentPage = 1;
        $this->currentRecord = 1;
    }

    protected function overLimit(): bool
    {
        return null !== $this->limit
            && Values::NONE !== $this->limit
            && $this->limit < $this->currentRecord;
    }

    protected function overPageLimit(): bool
    {
        return null !== $this->pageLimit
            && Values::NONE !== $this->pageLimit
            && $this->pageLimit < $this->currentPage;
    }
}
