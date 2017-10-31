import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HomeRoutingModule } from './home-routing.module';
import { DialogVideoComponent, HomeComponent } from './home.component'
import { FlexLayoutModule } from '@angular/flex-layout';
import { MatButtonModule, MatDialogModule } from '@angular/material'
import { HttpClientModule } from '@angular/common/http';
import { HttpModule } from '@angular/http';

@NgModule({
  imports: [
    CommonModule,
    HomeRoutingModule,
    HttpModule,
    HttpClientModule,
    FlexLayoutModule,
    MatButtonModule,
    MatDialogModule
  ],
  entryComponents: [
    DialogVideoComponent
  ],
  declarations: [HomeComponent, DialogVideoComponent]
})
export class HomeModule { }
