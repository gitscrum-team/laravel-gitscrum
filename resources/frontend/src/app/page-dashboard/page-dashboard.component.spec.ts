import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { PageDashboardComponent } from './page-dashboard.component';

describe('PageDashboardComponent', () => {
  let component: PageDashboardComponent;
  let fixture: ComponentFixture<PageDashboardComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PageDashboardComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PageDashboardComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
