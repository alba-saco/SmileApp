import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class QuizFormService {

  constructor(private _httpClient: HttpClient) {}

  postResponses(responses: Object, chapterID: number): Observable<number> {
    this._httpClient.post(attempts_API, 1).subscribe();
    return this._httpClient.post<number>(API + '?chapter_id=' + chapterID, responses);
  };

}

const API = "https://0067team14site.azurewebsites.net/api_files/post_quiz.php";

const attempts_API = "https://0067team14site.azurewebsites.net/api_files/quiz_attempts.php";