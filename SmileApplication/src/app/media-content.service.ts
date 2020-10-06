import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from 'rxjs';
import { Category, Chapter, Content, Quiz } from './types';

@Injectable()
export class MediaContentService {

  public categoryImages: Array<Object> = [];

  constructor(private _httpClient: HttpClient) { }

  getCategory(categoryID: number): Observable<Category>{
    return this._httpClient.get<Category>(category_API + "?category_id=" + categoryID);
  }

  getAllCategories(): Observable<Category[]>{
    return this._httpClient.get<Category[]>(category_API);
  }

  getChapter(categoryID: number, chapterID: number): Observable<Chapter>{
    return this._httpClient.get<Chapter>(chapter_API + "?category_id=" + categoryID + "&chapter_id=" + chapterID);
  }

  getAllChapters(categoryID: number): Observable<Chapter[]>{
    return this._httpClient.get<Chapter[]>(chapter_API + "?category_id=" + categoryID);
  }

  getContent(chapterID: number): Observable<Content>{
    return this._httpClient.get<Content>(content_API + "?chapter_id=" + chapterID);
  }

  getQuiz(chapterID: number): Observable<Quiz>{
    return this._httpClient.get<Quiz>(quiz_API + "?chapter_id=" + chapterID);
  }

  getCategoryImage(imageName: string) {
    return this._httpClient.get(blob_API + '?container=categoryimages&imageName=' + imageName);
  }

  getChapterImage(imageName: string) {
    return this._httpClient.get(blob_API + '?container=chapterimages&imageName=' + imageName);
  }

  getReadingImage(imageName: string) {
    return this._httpClient.get(blob_API + '?container=readingimages&imageName=' + imageName);
  }

}

const category_API = "https://0067team14site.azurewebsites.net/api_files/categories_api.php";

const chapter_API = "https://0067team14site.azurewebsites.net/api_files/chapters_api.php";

const content_API = "https://0067team14site.azurewebsites.net/api_files/content_api.php";

const quiz_API = "https://0067team14site.azurewebsites.net/api_files/quiz_api.php";

const blob_API = "https://0067team14site.azurewebsites.net/api_files/blob_test2.php";