<?php
namespace KapitchiContact\Plugin;

use Zend\EventManager\EventInterface,
    KapitchiApp\PluginManager\PluginInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class KapitchiLucene implements PluginInterface
{
    
    public function getAuthor()
    {
        return 'Matus Zeman';
    }

    public function getDescription()
    {
        return 'Adds lucene search.';
    }

    public function getName()
    {
        return '[KapitchiContact] Lucene search';
    }

    public function getVersion()
    {
        return '0.1';
    }
    
    public function onBootstrap(EventInterface $e)
    {
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        $sharedEm = $em->getSharedManager();
        
        $sharedEm->attach('KapitchiLucene\Service\Lucene', 'rebuildIndex', function($e) use ($sm) {
            if($e->getParam('indexHandle') == 'search') {
                $service = $sm->get('KapitchiContact\Service\Contact');
                $index = $e->getParam('index');
                foreach($service->getPaginator() as $entity) {
                    $model = $service->loadModel($entity);
                    $typeHandle = $entity->getTypeHandle();
                    
                    $doc = new \Zend_Search_Lucene_Document();
                    $doc->addField(\Zend_Search_Lucene_Field::keyword('entityType', 'contact'));
                    $doc->addField(\Zend_Search_Lucene_Field::keyword('entityId', $entity->getId()));
                    $doc->addField(\Zend_Search_Lucene_Field::keyword('contactType', $typeHandle));
                    $doc->addField(\Zend_Search_Lucene_Field::text('name', $entity->getDisplayName()));
                        
                    if($typeHandle == 'individual') {
                        $typeInstance = $model->getTypeInstance();
                        $doc->addField(\Zend_Search_Lucene_Field::keyword('dob', $typeInstance->getDob()->format('Y-m-d')));
                        $doc->addField(\Zend_Search_Lucene_Field::keyword('personalId', $typeInstance->getPersonalId()));
                    }
                    else if($typeHandle == 'company') {
                        //TODO
                    }
                    else {
                        //TODO?
                    }
                    
                    $index->addDocument($doc);
                }
            }
        });
        
        $sharedEm->attach('KapitchiContact\Controller\ContactController', 'index.pre', function($e) use ($sm) {
            $request = $e->getTarget()->getRequest();
            $s = $request->getQuery()->get('s');
            
            $criteria = $e->getParam('paginatorCriteria');
            if(!empty($s['name'])) {
                //$criteria['name'] = $s['name']['q'];
                $criteria['dob'] = '1982-12-28';
                $criteria['__lucenesearch'] = true;
            }
            
        });
        
        $sharedEm->attach('KapitchiContact\Service\Contact', 'getPaginator', function($e) use ($sm) {
            $luceneService = $sm->get('KapitchiLucene\Service\Lucene');
            $contactService = $e->getTarget();
            $criteria = $e->getParam('criteria');
            
            if(empty($criteria['__lucenesearch'])) {
                return;
            }
            
            //$queryString = 'name:' . $criteria['name'];
            $queryString = 'dob:' . $criteria['dob'];
            $query = \Zend_Search_Lucene_Search_QueryParser::parse($queryString);
            $index = $luceneService->getIndex('search');
            
            $adapter = new \KapitchiLucene\Paginator\Adapter\Lucene($index, $query);
            $paginator = new \Zend\Paginator\Paginator($adapter);
            $paginator->setFilter(new \Zend\Filter\Callback(function($items) use ($contactService) {
                $ret = array();
                foreach($items as $item) {
                    $entityId = $item->entityId;
                    $ret[] = $contactService->find($entityId);
                }
                return $ret;
            }));
            
            return $paginator;
        }, 100);
    }
    
}