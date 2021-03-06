import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core'; import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms'

import { AppComponent } from './app.component'; 
import { NumberInputModule } from '../../modules/numberinput.module';

@NgModule({
    declarations: [
        AppComponent
    ],
    imports: [
        BrowserModule, CommonModule, FormsModule, NumberInputModule
    ],
    providers: [],
    bootstrap: [AppComponent]
})

export class AppModule { }
