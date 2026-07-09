import { createPortal } from "react-dom";

/**
 * ModalPortal renders children into document.body via React Portal.
 *
 * WHY: When React is embedded inside a CI3 template, the React #root div
 * sits inside CI3's layout hierarchy (main-container → inner-container → main → root).
 * Parent elements in the CI3 layout may have CSS properties like:
 *   - overflow: hidden
 *   - transform / will-change / filter / perspective
 *
 * These create a new "containing block" for position:fixed elements,
 * which causes fixed modals to be clipped or trapped inside the parent
 * instead of covering the full viewport.
 *
 * By portalling modals to document.body, they escape the CI3 DOM hierarchy
 * entirely and position correctly relative to the viewport.
 */
const ModalPortal = ({ children }) => {
    return createPortal(children, document.body);
};

export default ModalPortal;
