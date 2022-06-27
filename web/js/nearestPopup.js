var nearestPopupElement = document.querySelector('.nearest-popup');

if (nearestPopupElement) {
    var popupHeader = nearestPopupElement.querySelector('.nearest-header');

    popupHeader.addEventListener('mousedown', evt => {
        evt.preventDefault();
    
        var startCoords = {
            x: evt.clientX,
            y: evt.clientY
        };
    
        var dragged = false;
    
        var onMouseMove = function (moveEvt) {
            moveEvt.preventDefault();
            dragged = true;
    
            var shift = {
                x: startCoords.x - moveEvt.clientX,
                y: startCoords.y - moveEvt.clientY
            };
    
            startCoords = {
                x: moveEvt.clientX,
                y: moveEvt.clientY
            };
            
            var popupHeaderShiftCoords = {
                x: nearestPopupElement.offsetLeft - shift.x,
                y: nearestPopupElement.offsetTop - shift.y
            };
    
            // var getMoveLimits = function () {
            //     if (markShiftCoords.x < window.marker.MIN_X - window.marker.MARK_WIDTH / 2) {
            //         markShiftCoords.x = window.marker.MIN_X - window.marker.MARK_WIDTH / 2;
            //     }
    
            //     if (markShiftCoords.x > window.marker.maxX - window.marker.MARK_WIDTH / 2) {
            //         markShiftCoords.x = window.marker.maxX - window.marker.MARK_WIDTH / 2;
            //     }
    
            //     if (markShiftCoords.y < window.marker.MIN_Y - window.marker.MARK_HEIGHT) {
            //         markShiftCoords.y = window.marker.MIN_Y - window.marker.MARK_HEIGHT;
            //     }
    
            //     if (popupHeaderShiftCoords.y >popupHeaderShiftCoords.MAX_Y - popupHeaderShiftCoords.HEADER_HEIGHT) {
            //         markShiftCoords.y = window.marker.MAX_Y - window.marker.MARK_HEIGHT;
            //     }
            // };
    
            // getMoveLimits();
    
    
            nearestPopupElement.style.left = popupHeaderShiftCoords.x + 'px';
            nearestPopupElement.style.top = popupHeaderShiftCoords.y + 'px';
        };
    
        var onMouseUp = function (upEvt) {
            upEvt.preventDefault();
    
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
    
            if (dragged) {
                var onClickPreventDefault = function (removeEvt) {
                    removeEvt.preventDefault();
                    popupHeader.removeEventListener('click', onClickPreventDefault);
                };
                popupHeader.addEventListener('click', onClickPreventDefault);
            }
        };
        document.addEventListener('mousemove', onMouseMove);
        document.addEventListener('mouseup', onMouseUp);
    });    
}
