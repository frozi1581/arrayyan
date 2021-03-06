import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AppComponent } from './app.component';
import { DockingLayoutModule } from '../../modules/dockinglayout.module';
import { ButtonModule } from '../../modules/button.module';
import { TreeModule } from '../../modules/tree.module';

@NgModule({
  declarations: [
      AppComponent
  ],
  imports: [
      BrowserModule, CommonModule, DockingLayoutModule, ButtonModule, TreeModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})

export class AppModule { }