import { Component } from '@angular/core';

@Component({
    selector: 'app-root',
    templateUrl: './app.component.html'
})

export class AppComponent {
	getWidth() : any {
		if (document.body.offsetWidth < 750) {
			return '90%';
		}
		
		return 750;
	}
}