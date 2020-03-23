package local.autorepair.lab2.contoller;

import local.autorepair.lab2.core.Autoservice;
import local.autorepair.lab2.repo.AutoserviceRepository;
import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

@Controller
@RequiredArgsConstructor
public class AjaxRequestsController {
    @Autowired
    private AutoserviceRepository autoserviceRepository;

    @GetMapping("/api/autoservice/search/")
    public String getAutoservice(@RequestParam String name, Map<String, Object> model){
        model.clear();
        if(name == null || name.isEmpty()){
            model.put("badmessage", "Строка поиска пустая");
            return "admin_autoservices :: autoservices_fragment";
        }
        List<Autoservice> autoservices = autoserviceRepository.findAutoservicesByNameContaining(name);
        model.put("autoservices", autoservices);
        if(autoservices == null ||autoservices.isEmpty()){
            model.put("badmessage", "Ничего не найдено");
            return "admin_autoservices :: autoservices_fragment";
        }
        model.put("goodmessage","Найдено "+ autoservices.size() +" автосервисов");
        return "admin_autoservices :: autoservices_fragment";
    }


    @PostMapping(path = "/api/autoservice/short_update/{id}")
    public String getAutoservice(@PathVariable Long id, @RequestParam(defaultValue = "")String name,
                                 @RequestParam(defaultValue = "") String address, @RequestParam(defaultValue = "") String tel, @RequestParam(defaultValue = "") String email, Map<String, Object> model){
        model.clear();
        Autoservice autoservice = autoserviceRepository.getOne(id);
        if(name.isEmpty()){
            model.put("badmessageedit", "Введите название");
            return "admin_autoservices :: modalmsg";
        }
        autoservice.setName(name);
        if(address.isEmpty()){
            model.put("badmessageedit", "Введите адрес");
            return "admin_autoservices :: modalmsg";
        }
        autoservice.setAddress(address);
        autoservice.setEmail(email);
        if(tel.isEmpty()){
            model.put("badmessageedit", "Введите телефон");
            return "admin_autoservices :: modalmsg";
        }
        autoservice.setTel(tel);
        autoserviceRepository.save(autoservice);
        model.put("goodmessageedit","Автосервис '"+autoservice.getName()+"' изменен");
        return "admin_autoservices :: modalmsg";
    }

    @GetMapping("/api/autoservice/showAllFragment")
    public String getAutoservice(Map<String, Object> model){
        List<Autoservice> autoservices = autoserviceRepository.findAll();
        model.put("autoservices", autoservices);
        return "admin_autoservices :: autoservices_fragment";
    }
}

