import { LaravelGitscrumPage } from './app.po';

describe('laravel-gitscrum App', () => {
  let page: LaravelGitscrumPage;

  beforeEach(() => {
    page = new LaravelGitscrumPage();
  });

  it('should display message saying app works', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('app works!');
  });
});
