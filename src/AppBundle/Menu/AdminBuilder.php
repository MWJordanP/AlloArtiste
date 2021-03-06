<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminBuilder
 */
class AdminBuilder extends AbstractBuilder
{
    /**
     * @param FactoryInterface $factory
     * @param array            $options
     *
     * @return ItemInterface
     */
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        /** @var Request $request */
        $request   = $this->getRequest();
        $routeName = $request->get('_route');

        $this->addItem($menu, 'admin.menu.home', 'admin', 'home');
        $this->addItemAndCurrent('admin_job', $menu, 'admin.menu.job', 'admin_job_index', 'building');
        $this->addItemAndCurrent('admin_contact', $menu, 'admin.menu.contact', 'admin_contact_index', 'comment');

        return $menu;
    }
}
