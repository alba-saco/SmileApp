import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class StatsService {
  constructor(private _httpClient: HttpClient) { }

  addTimer() {
    this._httpClient.post(timer_API, 1).subscribe();
  }

  addReading() {
    this._httpClient.post(reading_API, 1).subscribe();
  }

  addVideo() {
    this._httpClient.post(video_API, 1).subscribe();
  }

}

const timer_API = "https://0067team14site.azurewebsites.net/api_files/timer_api.php";

const reading_API = "https://0067team14site.azurewebsites.net/api_files/reading_stats.php";

const video_API = "https://0067team14site.azurewebsites.net/api_files/video_stats.php";
