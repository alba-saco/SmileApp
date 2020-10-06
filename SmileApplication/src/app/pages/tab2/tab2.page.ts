import { Component } from '@angular/core';

import { Platform } from '@ionic/angular';
import { Router } from '@angular/router';
import { Observable } from 'rxjs';
import { Category } from '../../types';
import { MediaContentService } from '../../media-content.service';

@Component({
  selector: 'app-tab2',
  templateUrl: 'tab2.page.html',
  styleUrls: ['tab2.page.scss']
})
export class Tab2Page {
  topicsList: Array<Object> = [];
  imageList: Array<Object> =[];
  imageObject: Object = {};
  category_id: number;
  category_image_url: string;

  constructor(private platform: Platform,
    private router: Router,
    private mediaContentService: MediaContentService) {

    mediaContentService.getAllCategories().subscribe(categoryList => {
      categoryList.forEach(category => {
        var categoryObject = {};
        mediaContentService.getCategoryImage(category.category_image_url).subscribe(image => {
          categoryObject['category_image_url'] = image;
        });
        categoryObject['category_id'] = category.category_id;
        categoryObject['category_name'] = category.category_name;
        this.topicsList.push(categoryObject);
      })
    })

    }


  settings() {
    this.router.navigate(['tabs/settings'])
}

  topicpage() {
      this.router.navigate(['./tabs/topicpage'])
  }

  getAllCategories() {
    return this.mediaContentService.getAllCategories();
  }

  imageLinkObj(category_id, category_image_url) {
    this.category_id = category_id;
    this.category_image_url = category_image_url;
  }
  

}
