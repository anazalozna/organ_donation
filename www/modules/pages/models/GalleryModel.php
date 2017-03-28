<?php
/**
 * Created by Ana Zalozna
 * Date: 20/02/17
 * Time: 8:24 PM
 */

namespace Pages;

class GalleryModel extends \Model
{
	/**
	 * Get all the thumbnails
	 *
	 * @return array
	 */
	public function getThumbs() :array{
		$sql = "SELECT thumb, id, title FROM gallery ORDER BY id DESC";
		return $this->queryRows($sql);
	}

	/**
	 * Get a full-size image data
	 *
	 * @param int $id
	 * @return array
	 */
	public function getImageData(int $id) :array{
		$sql = "SELECT id, img, title, thumb, text FROM gallery
				WHERE id = :id";
		return $this->queryRow($sql, ['id' => $id]);
	}

	/**
	 * Save gallery image to file system
	 *
	 * @param string $img_full
	 * @param string $img_min
	 */
	public function saveImages(string $img_full, string $img_min){
		// full img
		rename($_FILES['img']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/'.$img_full);

		// min img
		\Gregwar\Image\Image::open($_SERVER['DOCUMENT_ROOT'].'/'.$img_full)
			->zoomCrop(270, 370, 'transparent', 'center', 'top')
			->save($_SERVER['DOCUMENT_ROOT'].'/'.$img_min);
	}

	/**
	 * Add new gallery row
	 *
	 * @param array $data
	 */
	public function addGallery(array $data){
		$this->insertRow('gallery', $data);
	}

	/**
	 * Delete gallery images
	 *
	 * @param int $id
	 */
	public function deleteImages(int $id){
		$images = $this->queryRow("SELECT img, thumb FROM gallery WHERE id = :id", ['id' => $id]);
		foreach ($images as $image){
			unlink($_SERVER['DOCUMENT_ROOT'].'/'.$image);
		}
	}

	/**
	 * Delete gallery row
	 *
	 * @param int $id
	 */
	public function delete(int $id){
		$this->deleteImages($id);
		$this->deleteById($id, 'gallery');
	}

	/**
	 * Edit gallery
	 *
	 * @param int $id
	 * @param $data
	 */
	public function editGallery(int $id, $data){
		if(isset($data['thumb']) && isset($data['img'])){
			$sql = "UPDATE gallery SET thumb = :thumb, img = :img, title = :title, text = :text WHERE id = :id";
		}else{
			$sql = "UPDATE gallery SET title = :title, text = :text WHERE id = :id";
		}

		$stmt = $this->_pdo->prepare($sql);
		$stmt->execute(array_merge($data, ['id' => $id]));
	}
}