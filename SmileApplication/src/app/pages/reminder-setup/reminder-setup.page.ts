import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Location } from '@angular/common';

@Component({
  selector: 'app-reminder-setup',
  templateUrl: './reminder-setup.page.html',
  styleUrls: ['./reminder-setup.page.scss'],
})
export class ReminderSetupPage implements OnInit {

    constructor(private router: Router, private location: Location) { }

    home() {
        this.router.navigate(['/tabs'])
    }
    reminders() {
        this.router.navigate(['tabs/reminders'])
    }
    back() {
        this.location.back();
    }

  ngOnInit() {
  }

}
