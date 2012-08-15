<?php
namespace KapitchiContact\ContactType;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
abstract class AbstractContactType implements ContactTypeInterface
{
    protected $typeService;
    protected $form;
    
    public function getTypeService()
    {
        return $this->typeService;
    }

    public function setTypeService($typeService)
    {
        $this->typeService = $typeService;
    }
    
    public function getForm($formType)
    {
        return $this->form;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }
    
}