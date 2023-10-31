import type { BodyClasses } from "@/store/types/root";
import { isTouchDevice } from "@/utils/userAgentCheck";

export const bodyClasses = (classObj: BodyClasses) => {
  let body = document.getElementsByTagName('body')[0];
  const { modalOpen, navMenuOpen, navSearchActive } = classObj;
  let bodyClasses : string[] = [
    isTouchDevice() ? 'touch-device' : 'no-touch-device',
    ...modalOpen ? ['modal-open'] : [],
    ...navMenuOpen ? ['nav-menu-open'] : [],
    ...navSearchActive ? ['nav-search-active'] : [],
  ];

  body.className = "";
  body.classList.add(...bodyClasses);
}
