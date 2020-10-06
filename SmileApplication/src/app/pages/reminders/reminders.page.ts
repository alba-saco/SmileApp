import { Component, OnInit } from '@angular/core';

import { Router } from '@angular/router';
import { Location } from '@angular/common';

import { LocalNotifications } from '@ionic-native/local-notifications/ngx';
import { Platform, AlertController } from '@ionic/angular';

@Component({
  selector: 'app-reminders',
  templateUrl: './reminders.page.html',
  styleUrls: ['./reminders.page.scss'],
})
export class RemindersPage implements OnInit {
    d = new Date;
    currentMonth = this.d.getMonth() + 1;
    currentDate = this.d.getDate();
    frequency = ['0', '1', '2', '3', '4'];
    brushRemindrNo = [];
    flossRemindrNo = [];
    replaceEn = '0';
    dentistEn = '0';
    counter = 0;

    constructor(
        private router: Router, 
        private location: Location, 
        private localNotifications: LocalNotifications, 
        private plt: Platform, 
        private alertCtrl: AlertController,
        ) { 
            this.plt.ready().then(() => {
                this.localNotifications.on('trigger').subscribe(res => {
                    this.showAlert(res.title, res.text);
                });
            });

    };

    showAlert(header, sub) {
        this.alertCtrl.create({
            header: header,
            subHeader: sub,
            buttons: ['Ok']
        }).then(alert => alert.present());
    };

    back() {
        this.location.back();
    };

    home() {
        this.router.navigate(['./tabs']);
    };

    brushFrequency($event) {
        this.brushRemindrNo = Array.from(Array(parseInt($event.detail.value)).keys());
    };

    flossFrequency($event) {
        this.flossRemindrNo = Array.from(Array(parseInt($event.detail.value)).keys());
    };

    setDailyNotification(id, title, text, time) {
        time = new Date(time)
        this.localNotifications.schedule({
            id: id,
            title: title,
            text: text,
            foreground: true,
            vibrate: true,
            launch: true,
            trigger: { every: { hour: time.getHours(), minute: time.getMinutes() } },
        })
    };

    setMonthlyNotification(id, title, text, month) {
        this.localNotifications.schedule({
            id: id,
            title: title,
            text: text,
            foreground: true,
            vibrate: true,
            launch: true,
            trigger: { every: { month: month, day: 5, hour: 9 } },
        })

    };

    saveReminders() {
        for (let i = 0; i < this.brushRemindrNo.length; i++) {
            this.setDailyNotification(i, "Brush Teeth", "Time to brush your teeth for healthier teeth!", this.brushRemindrNo[i])
        };
        if (this.brushRemindrNo.length === 0) { for (let i = 0; i < 4; i++) {
            this.localNotifications.cancel({ id: i })
        }};
        

        for (let i = 0; i < this.flossRemindrNo.length; i++) {
            this.setDailyNotification(i + 3, "Floss", "Time to floss for better oral hygine results!", this.flossRemindrNo[i])
        };
        if (this.flossRemindrNo.length === 0) { for (let i = 0; i < 4; i++) {
            this.localNotifications.cancel({ id: i + 3 })
        }};


        if (parseInt(this.replaceEn) !== 0) {
            this.counter = 12/(parseInt(this.replaceEn))
            for (let i = 0; 0 < this.counter;i += parseInt(this.replaceEn), this.counter -= 1) {
                this.setMonthlyNotification(i + 30, "Replace Toothbrush", 
                "It's time to replace your toothbrush for better cleaning results!", (this.currentMonth + i) % 12)
            }} else if (parseInt(this.replaceEn) === 0) { for (let j = 30; j < 45; j++) {
                this.localNotifications.cancel({ id: j })
            }
        };


        if (parseInt(this.dentistEn) !== 0) {
            this.counter = 12/(parseInt(this.dentistEn))
            for (let i = 0; 0 < this.counter;i += parseInt(this.dentistEn), this.counter -= 1) {
                this.setMonthlyNotification(i + 50, "Make a Dentist Appointment", 
                "It's time to make a new dentist appointment for routine checkup!", (this.currentMonth + i) % 12)
            }} else if (parseInt(this.replaceEn) === 0) { for (let j = 50; j < 65; j++) {
                this.localNotifications.cancel({ id: j })
            }
        };
        
        this.showAlert("Saved", "Your reminder settings have been saved.");
        this.home();
    };

    cancelReminders() {
        this.localNotifications.cancelAll();
        this.showAlert("Cancelled", "All of your reminders have been cancelled.");
        this.home();
    };

  ngOnInit() {
  };

};