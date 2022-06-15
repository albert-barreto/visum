<?php

namespace App\Controller;

use App\Entity\Video;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/videos", name="api_videos", methods={"GET"})
     * @return Response
     */
    public function getVideos(): Response
    {
        $allVideos = $this->getDoctrine()->getRepository(Video::class)->findAll();
        foreach ($allVideos as $video) {
            $videos[] = [
                "id" => $video->getId(),
                "title" => $video->getTitle(),
                "path" => $video->getPath(),
                "duration" => $video->getDuration()
            ];
        }
        return $this->json($videos, 200);
    }

    /**
     * @Route("/videos/{id}", name="api_video", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getVideo(int $id): Response
    {
        $video = $this->getDoctrine()->getManager()->getRepository(Video::class)->find($id);
        return $this->json([  
            "id" => $video->getId(),
            "title" => $video->getTitle(),
            "path" => $video->getPath(),
            "duration" => $video->getDuration()
        ], 200);
    }

    /**
     * @Route("/categories", name="api_categories", methods={"GET"})
     * @return Response
     */
    public function getCategories(): Response
    {
        $allCategories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        foreach ($allCategories as $category) {
            $categories[] = [
                "id" => $category->getId(),
                "name" => $category->getName(),
                "parent" => (is_null($category->getParent()) ? null : $category->getParent()->getName())
            ];
        }
        return $this->json($categories, 200);
    }

    /**
     * @Route("/categories/{id}", name="api_category", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function getCategory(int $id): Response
    {
        $category = $this->getDoctrine()->getManager()->getRepository(Category::class)->find($id);
        return $this->json([  
            "id" => $category->getId(),
            "name" => $category->getName(),
            "parent" => (is_null($category->getParent()) ? null : $category->getParent()->getName())
        ], 200);
    }
}
