<?php
namespace KapitchiContact\ContactType;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
abstract class AbstractEntityContactType implements ContactTypeInterface
{
    protected $entityService;
    protected $form;

    public function getEntityService()
    {
        return $this->entityService;
    }

    public function setEntityService(\KapitchiEntity\Service\EntityService $entityService)
    {
        $this->entityService = $entityService;
    }

    public function getForm($formType = null)
    {
        return $this->form;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }
    
    public function createArrayFromType($type)
    {
        return $this->getEntityService()->createArrayFromEntity($type);
    }

    public function createTypeFromArray(array $data)
    {
        return $this->getEntityService()->createEntityFromArray($data);
    }
}