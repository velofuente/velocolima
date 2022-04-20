function scheduleByInstructor() {
  var selectInstructor = document.getElementById("ScheduleInstructor").value;
  var scheduleBox = document.getElementsByClassName("scheduleItem");

  if (selectInstructor == "allInstructors"){
      for (let item of scheduleBox){
          item.style.display = 'block';
      }
  } else {
      for (let item of scheduleBox){
          if (selectInstructor === item.id){
              item.style.display = 'block';
          }
          else {
              item.style.display = 'none';
          }
      }
  }
}

function getBrandListByPlace (selectedPlace) {
    $.ajax({
        url: "/api/brandList",
        method: 'GET',
        data: {
            _token: token,
            place_id: selectedPlace
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        success: function (response) {
            var data = response.data;
            var brands = data.brands;
            var options = `<option value="allBrands" selected="selected">Estudio</option>`;
            brands.forEach(brand => {
                options += `<option value=${brand.id}>${brand.name}</option>`;
            });
            $('#brands').html(options);
            $.LoadingOverlay("hide");
        },
        failure: function () {
            $.LoadingOverlay("hide");
        },
        error: function (result) {
            $.LoadingOverlay("hide");
        }
    });
}

function getBranchesListByBrand (selectedBrand) {
    $.ajax({
        url: "/api/branchesList",
        method: 'GET',
        data: {
            _token: token,
            brand_id: selectedBrand
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        success: function (response) {
            var data = response.data;
            var branches = data.branches;
            var options = `<option value="allBranches" selected="selected">Sucursal</option>`;
            branches.forEach(branch => {
                options += `<option value=${branch.id}>${branch.name}</option>`;
            });
            $('#branches').html(options);
            $.LoadingOverlay("hide");
        },
        failure: function () {
            $.LoadingOverlay("hide");
        },
        error: function (result) {
            $.LoadingOverlay("hide");
        }
    });
}

function getScheduleListByBranch (selectedBranch, buyPackages = false) {
    $.ajax({
        url: `/api/scheduleList/${selectedBranch}`,
        method: 'GET',
        data: {
            _token: token,
            buy_packages: buyPackages
        },
        beforeSend: function () {
            $.LoadingOverlay("show");
        },
        success: function (response) {
            var data = response.data;
            var brand = data.brand;
            var calendar = data.calendar;
            var products = data.products;
            var schedules = data.schedules;

            if (schedules.length === 0) {
                $('#calendario').html('<h4 class="text-center text-white">No se encontrar clases disponibles para los próximos días.</h4>');
            } else {
                var div = $("<div id='rowSchedule' class='row' name='dates'></div>");
                calendar.forEach(function (date) {
                    var ul = $('<ul></ul>');
                    var section = $(`<section id="scheduleDayColumn" class="col"></section>`);
                    ul.append($(`<li class="scheduleDayText"><span class="number">${date.title}</span></li>`));
                    schedules.forEach(schedule => {
                        if (schedule.day != date.formatted) { return; }
                        var liClass = 'scheduleItem';
                        var hourClass = 'scheduleItemTextHour';
                        var itemHour = $(`<p>${schedule.hour}</p>`);
                        var sectionContainerClass = 'scheduleItemContainerDescription';
                        var liElement = $(`<li id="${schedule.instructor_name}">`);
                        var mainElement = $(`<a href="/bike-selection/${schedule.id}" class="scheduleItemLink"></a>`);
                        var sectionContainer = $('<section></section>');

                        if (schedule.disable) {
                            liClass = 'scheduleItemDisabled';
                            hourClass = 'scheduleItemTextHourDisabled';
                            mainElement = $('<span class="scheduleItemLinkDisabled"></span>');
                            sectionContainerClass = 'scheduleItemContainer';
                        }

                        // Agregar clases a los elementos
                        liElement.addClass(liClass);
                        itemHour.addClass(hourClass);
                        sectionContainer.addClass(sectionContainerClass);

                        sectionContainer.append($(`<p class="scheduleItemTextInstructor">${schedule.instructor_name}</p>`));
                        if (schedule.show_description) {
                            sectionContainer.append($(`<p class="scheduleDescription">${schedule.description}</p>`));
                        }
                        sectionContainer.append(itemHour);

                        liElement.append(sectionContainer);
                        mainElement.append(liElement)
                        ul.append(mainElement);
                    });

                    section.append(ul);
                    div.append(section);
                });
                $('#calendario').html(div);
            }

            var productSection = $('.classes');
            productSection.html('');
            products.forEach(product => {
                var prefixClass = product.n_classes == 1 ? 'CLASE' : 'CLASES';
                var h3Id = product.promotional == 1 ? 'amountDeal' : 'amount6';
                var customClass = product.promotional == 1 ? 'content-normal-deal' : 'content-normal';
                var productContainer = $(`<div class="content-normal pickClass mx-2" id="prod-${product.id}"></di>`);
                var modal = $(`<div id="${customClass}" class="px-4 content-n" data-toggle="modal" data-target="#loginModal"></div>`);
                if (!data.guest) {
                    if (data.num_cards > 0) {
                        var modal = $(`<div id="${customClass}" class="px-4 content-n" data-toggle="modal" data-target="#savedCardsModal"></div>`);
                    } else {
                        var modal = $(`<div id="${customClass}" class="px-4 content-n" data-toggle="modal" data-target="#newCardChargeModal"></div>`);
                    }
                }
                modal.append((product.promotional ? `<h5 id="package-description" class="mt-0 text-center mx-auto">Promoción <br><span id="DBDescription" class="text-center mx-auto">${product.description}<span></h5>` : '')
                + `<h3 id="${h3Id}">${product.n_classes}</h3><h4 class="class">${prefixClass}</h4><p class="precio" style="font-size: 17px; font-family: 'Avenir Next Condensed'; font-weight: 300;">$${product.price}</p><p class="exp" style="font-size: 17px;">Expira: ${product.expiration_days} días</p>`);
                productContainer.append(modal);
                productSection.append(productContainer);
            });

            $('#branchTitle').html(brand.name);
            if(brand.name == "Forte"){
                document.querySelector("#brandName").innerHTML = brand.name;
            } 
            $('#packages').removeClass('hidden');
            $.LoadingOverlay("hide");
            pathName = window.location.href;
            var tags = pathName.split('#');
            if (tags[tags.length - 1] == 'packages') {
                $('html, body').animate({
                    scrollTop: $("#packages").offset().top
                }, 0);
            }
        },
        failure: function () {
            $.LoadingOverlay("hide");
        },
        error: function (result) {
            $.LoadingOverlay("hide");
        }
    });
}

