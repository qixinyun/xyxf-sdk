<?php
namespace Sdk\Common\Translator;

trait RestfulTranslatorTrait
{
    protected function includedAttributes($included)
    {
        $result = array();
        foreach ($included as $each) {
            if (isset($each['type']) && isset($each['id'])) {
                $result[$each['type']][$each['id']] = isset($each['attributes']) ? $each['attributes'] : '';
            }
        }
        return $result;
    }

    protected function includedRelationships($included)
    {
        $result = array();
        foreach ($included as $each) {
            if (isset($each['relationships']) && isset($each['type']) && isset($each['id'])) {
                $result[$each['type']][$each['id']] = $each['relationships'];
            }
        }
        return $result;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function relationship($included, $relationships)
    {
        $attributes = $this->includedAttributes($included);
        $includedRelationships = $this->includedRelationships($included);

        $relationship = array();
        foreach ($relationships as $key => $val) {
            if (isset($val['data'][0])) {
                foreach ($val['data'] as $k => $v) {
                    if (isset($v['type'])
                        && isset($v['id'])
                        && isset($attributes[$v['type']][$v['id']])
                    ) {
                        $relationship[$key]['data'][$k]['type'] = $v['type'];
                        $relationship[$key]['data'][$k]['id'] = $v['id'];
                        $relationship[$key]['data'][$k]['attributes'] = $attributes[$v['type']][$v['id']];
                    }
                    if (isset($v['type'])
                        && isset($v['id'])
                        && isset($includedRelationships[$v['type']][$v['id']])
                    ) {
                        $relationship[$key]['data'][$k]['relationships'] =
                            $includedRelationships[$v['type']][$v['id']];
                    }
                }
            }

            if (!isset($val['data'][0])) {
                if (isset($val['data']['type'])
                    && isset($val['data']['id'])
                    && isset($attributes[$val['data']['type']][$val['data']['id']])
                ) {
                    $relationship[$key]['data']['type'] = $val['data']['type'];
                    $relationship[$key]['data']['id'] = $val['data']['id'];
                    $relationship[$key]['data']['attributes'] = $attributes[$val['data']['type']][$val['data']['id']];
                }

                if (isset($val['data']['type'])
                    && isset($val['data']['id'])
                    && isset($includedRelationships[$val['data']['type']][$val['data']['id']])
                ) {
                    $relationship[$key]['data']['relationships'] =
                        $includedRelationships[$val['data']['type']][$val['data']['id']];
                }
            }
        }

        return $relationship;
    }

    protected function changeArrayFormat($relationships, $included = array())
    {

        $relationship['data'] = $relationships;
        if (!empty($included)) {
            $relationship['included'] = $included;
        }

        return $relationship;
    }

    public function arrayToObjects(array $expression) : array
    {
        if (empty($expression)) {
            return array(0,array());
        }

        if (isset($expression['data'][0])) {
            $results = array();
            foreach ($expression['data'] as $each) {
                $each['data'] = $each;
                if (isset($expression['included'])) {
                    $each['included'] = $expression['included'];
                }
                $results[$each['id']] = $this->translateToObject($each);
            }

            $count = isset($expression['meta']['count']) ? $expression['meta']['count'] : sizeof($results);
            return [$count, $results];
        }

        return [1, [$expression['data']['id']=>$this->translateToObject($expression)]];
    }
}
