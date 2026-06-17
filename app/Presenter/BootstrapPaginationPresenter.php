<?php

namespace DomainProvider\Presenter;

use Illuminate\Pagination\BootstrapThreePresenter;

class BootstrapPaginationPresenter extends BootstrapThreePresenter
{
    /**
     * Render pagination
     *
     * @return string
     */
    public function render()
    {
        if ($this->hasPages()) {
            return sprintf(
                '<ul class="pagination pagination-sm no-margin pull-right">%s %s %s</ul>',
                $this->getPreviousButton(),
                $this->getLinks(),
                $this->getNextButton()
            );
        }

        return '';
    }
}
