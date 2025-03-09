<?php

namespace App\Http\Transformers;

use Illuminate\Pagination\UrlWindow;
use League\Fractal\Pagination\PaginatorInterface;
use League\Fractal\Serializer\ArraySerializer;
use Illuminate\Support\Facades\URL;

class CustomArraySerializer extends ArraySerializer
{
    public function paginator(PaginatorInterface $paginator): array
    {
        $currentPage = (int)$paginator->getCurrentPage();
        $lastPage = (int)$paginator->getLastPage();
        $allQueryParams = request()->query();
        $filteredParams = collect($allQueryParams)->except('page')->all();

        $from = (int)$paginator->getPerPage() * ($currentPage - 1) + 1;
        $pagination = [
            'from' => $from,
            'to' => (int)$from + $paginator->getCount() - 1,
            'total' => (int)$paginator->getTotal(),
            'count' => (int)$paginator->getCount(),
            'per_page' => (int)$paginator->getPerPage(),
            'current_page' => $currentPage,
            'total_pages' => $lastPage,
        ];

        $pagination['links'] = [];

        $previous = (object)['label' => 'Previous'];
        if ($currentPage > 1) {
            $previous = (object)[
                'label' => 'Previous',
                'url' => $this->appendQueryParamsToUrl($paginator->getUrl($currentPage - 1), $filteredParams)
            ];
        }
        $next = (object)['label' => 'Next'];
        if ($currentPage < $lastPage) {
            $next = (object)[
                'label' => 'Next',
                'url' => $this->appendQueryParamsToUrl($paginator->getUrl($currentPage + 1), $filteredParams)
            ];
        }
        $elementPaginatiors = $this->elements($paginator->getPaginator());
        $numberedPaginators = [];
        foreach ($elementPaginatiors as $pag) {
            $numberedPaginators[] = (object)[
                'label' => $pag->label,
                'url' => isset($pag->url) ? $this->appendQueryParamsToUrl($pag->url, $filteredParams) : null,
                'active' => $pag->active ?? null
            ];
        }
        /** @phpstan-ignore-next-line */
        $pagination['links'] = array_merge([$previous], $numberedPaginators, [$next]);
        return ['pagination' => $pagination];
    }

    protected function appendQueryParamsToUrl($url, $queryParams): string
    {
        if (empty($queryParams)) {
            return $url;
        }

        $separator = (strpos($url, '?') !== false) ? '&' : '?';
        return $url . $separator . http_build_query($queryParams);
    }

    protected function elements($paginator)
    {
        $window = UrlWindow::make($paginator);

        $result = [];

        $currentPage = $paginator->currentPage();

        foreach ($window['first'] as $label => $url) {
            $result [] = $this->getPageData($label, $url, $currentPage);
        }

        if (is_array($window['slider'])) {
            $result [] = (object)['label' => '...'];
            foreach ($window['slider'] as $label => $url) {
                $result [] = $this->getPageData($label, $url, $currentPage);
            }
        }

        if (is_array($window['last'])) {
            $result [] = (object)['label' => '...'];
            foreach ($window['last'] as $label => $url) {
                $result [] = $this->getPageData($label, $url, $currentPage);
            }
        }

        return $result;
    }

    protected function getPageData($label, $url, $currentPage)
    {
        $pageData = ['label' => (string)$label, 'url' => $url];
        if ($currentPage === $label) {
            $pageData['active'] = true;
        }

        return (object)$pageData;
    }
}
