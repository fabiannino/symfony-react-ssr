<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Categories;
use \DateTime;

class AdminCategoriesController extends AbstractController
{

    /**
     * @Route("/admin/categories", name="admin_categories")
     */
    public function index()
    {

        $category = [
            "id" => 17,
            "link" => 'sopa',
            "name" => 'Sopa!',
            "image" => '',
            "status" => 1,
            "sort" => 1,
            "dateAdded" => new DateTime(),
            "dateAvailable" => new DateTime(),
        ];

        $this->execute('update', $category);
        // $this->execute('create', $category);
        // $this->delete(2);

        // $info = $this->read('sopa');
        // print_r($info->getName());

        return $this->render('admin_categories/index.html.twig', [
            'controller_name' => 'AdminCategoriesController',
        ]);
    }

    /*
     * Get Category Info from DB
     */
    private function read($categoriesId) : ?Categories {
        if(is_int($categoriesId)) {
            return $this->getDoctrine()->getRepository(Categories::class)->find($categoriesId);
        } else {
            return $this->getDoctrine()->getRepository(Categories::class)->findByLink($categoriesId);
        }
    }

    /*
     * Inserts or updates a new category
     */
    private function execute($action, $category) :void
    {

        // Check if Link already exists perform an update
        $cat = $this->read($category['link']);
        if($cat) $action = 'update';
        
        switch($action) {
            case 'create':
                // If not exists, create new
                $cat = new Categories();
                $sort = $this->getDoctrine()->getRepository(Categories::class)->getNextSort();
            break;
            case 'update':
                if(!$cat) $cat = $this->read($category['id']);
                $sort = $category['sort'];
            break;
        }
        $cat->setLink($category['link']);
        $cat->setName($category['name']);
        $cat->setImage($category['image']);
        $cat->setStatus($category['status']);
        $cat->setSort($sort);
        $cat->setDateAdded($category['dateAdded']);
        $cat->setDateAvailable($category['dateAvailable']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cat);
        $em->flush();
    }

    /*
     * Detetes a category by Id
     */
    private function delete($categoriesId) :void
    {
        $category = $this->read($categoriesId);
        if(!$category) {
            return;
        }
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();
    }
}
