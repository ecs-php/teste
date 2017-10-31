import { Component, OnInit } from '@angular/core';
import { ApiService } from '../common/api.service';
import { Winners } from '../common/winners';
import { Draws } from '../common/draws';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { MatDialog, MatDialogRef } from '@angular/material'

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  providers: [ApiService]
})
export class HomeComponent implements OnInit {
  private url = 'http://localhost/api';
  private headers = new HttpHeaders().set('Content-Type', 'application/json').set('Authorization', '1029371929182');
  winners: Winners[];
  draws: Draws[];

  constructor (private http: HttpClient, public dialog: MatDialog) { }

  ngOnInit () {
    this.getWinners();
    this.getDraws();
  }

  getWinners() {
    this.http.get<Winners[]>(this.url + '/winners', {headers: this.headers}).subscribe(res => {
      this.winners = res;
    });
  }

  getDraws() {
    this.http.get<Draws[]>(this.url + '/draws', {headers: this.headers}).subscribe(res => {
      this.draws = res;
    });
  }

  openDialog(): void {
    const dialogRef = this.dialog.open(DialogVideoComponent, {
      height: '315',
      width: '560',
    });
  }

}

@Component({
  selector: 'app-dialog-video',
  templateUrl: 'dialog.component.html',
})
export class DialogVideoComponent {

  constructor(public dialogRef: MatDialogRef<DialogVideoComponent>) { }

  onNoClick(): void {
    this.dialogRef.close();
  }

}