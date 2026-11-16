
import Alpine from 'alpinejs';
import OpenSeadragon from 'openseadragon';
import registerPathologyViewer from './pathology-viewer';
import registerSlideUpload from './slide-upload';
import registerUi from './ui';


window.Alpine = Alpine;
registerPathologyViewer(Alpine);
registerSlideUpload(Alpine);
registerUi(Alpine);
Alpine.start();
window.OpenSeadragon = OpenSeadragon;
