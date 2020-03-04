<?php
namespace Sdk\Policy\Translator;

use Sdk\Policy\Model\PolicyModelFactory;

use Sdk\Policy\Model\Policy;

trait PolicyRestfulTranslatorTrait
{
    protected function setUpApplicableObjects($applicableObject)
    {
        $applicableObjects = [];
        foreach ($applicableObject as $applicableObjectsId) {
            $applicableObjects[] = PolicyModelFactory::create(
                $applicableObjectsId,
                PolicyModelFactory::TYPE['POLICY_APPLICABLE_OBJECT']
            );
        }

        return $applicableObjects;
    }

    protected function setUpApplicableIndustries($applicableIndustrie)
    {
        $applicableIndustries = [];
        foreach ($applicableIndustrie as $applicableIndustriesId) {
            $applicableIndustries[] = PolicyModelFactory::create(
                $applicableIndustriesId,
                PolicyModelFactory::TYPE['POLICY_APPLICABLELNDUSTRIES']
            );
        }

        return $applicableIndustries;
    }

    protected function setUpClassifies($classifie)
    {
        $classifies = [];
        foreach ($classifie as $classifiesId) {
            $classifies[] = PolicyModelFactory::create(
                $classifiesId,
                PolicyModelFactory::TYPE['POLICY_CLASSIFY']
            );
        }

        return $classifies;
    }

    protected function setUpDispatchDepartments(array $dispatchDepartments, Policy $policy)
    {
        foreach ($dispatchDepartments as $dispatchDepartmentsArray) {
            $dispatchDepartments = $this->changeArrayFormat($dispatchDepartmentsArray);
            $dispatchDepartmentsObject = $this->getDispatchDepartmentRestfulTranslator()
                                            ->arrayToObject($dispatchDepartments);
            $policy->addDispatchDepartment($dispatchDepartmentsObject);
        }
    }

    protected function setUpLabels(array $labels, Policy $policy)
    {
        foreach ($labels as $labelsArray) {
            $labels = $this->changeArrayFormat($labelsArray);
            $labelsObject = $this->getLabelRestfulTranslator()->arrayToObject($labels);
            $policy->addLabel($labelsObject);
        }
    }

    protected function setUpDispatchDepartmentsArray(Policy $policy)
    {
        $dispatchDepartmentsArray = [];

        $dispatchDepartments = $policy->getDispatchDepartments();
        foreach ($dispatchDepartments as $dispatchDepartmentsKey) {
            $dispatchDepartmentsArray[] = array(
                    'type' => 'dispatchDepartments',
                    'id' => $dispatchDepartmentsKey->getId()
                );
        }

        return $dispatchDepartmentsArray;
    }

    protected function setUpLabelsArray(Policy $policy)
    {
        $labelsArray = [];

        $labels = $policy->getLabels();
        foreach ($labels as $labelsKey) {
            $labelsArray[] = array(
                    'type' => 'labels',
                    'id' => $labelsKey->getId()
                );
        }

        return $labelsArray;
    }
}
