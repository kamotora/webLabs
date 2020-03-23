package local.autorepair.lab2.contoller;

import local.autorepair.lab2.core.Autoservice;
import local.autorepair.lab2.core.Service;
import local.autorepair.lab2.repo.AutoserviceRepository;
import local.autorepair.lab2.repo.ServiceRepository;
import local.autorepair.lab2.util.ParseCheckboxFromBody;
import lombok.RequiredArgsConstructor;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.*;

import java.sql.Date;
import java.util.ArrayList;
import java.util.List;
import java.util.Set;

@Controller
@RequiredArgsConstructor
public class AutoserviceController {
    @Autowired
    private AutoserviceRepository autoserviceRepository;
    @Autowired
    private ServiceRepository serviceRepository;

    @GetMapping("/")
    public String redirectToMainPage(Model model){
        return "redirect:/admin_autoservices";
    }
    @GetMapping("/error")
    public String show404(Model model){
        return "redirect:/404";
    }

    @GetMapping("admin_autoservices")
    public String getAutoservices(Model model){
        List<Autoservice> autoservices = autoserviceRepository.findAll();
        model.addAttribute("autoservices", autoservices);
        model.addAttribute("title", "Редактирование автосервисов");
        return "admin_autoservices";
    }

    @GetMapping("/api/autoservice/get/{id}")
    public String getAutoservice(@PathVariable Long id, Model model){
        Autoservice autoservice = autoserviceRepository.getOne(id);
        model.addAttribute("autoservice", autoservice);
        return "one_autoservice_admin";
    }


    @GetMapping("one_autoservice/{id}")
    public String showAutoservice(@PathVariable Long id, Model model){
        Autoservice autoservice = autoserviceRepository.getOne(id);
        model.addAttribute("autoservice", autoservice);
        List<Service> services = serviceRepository.findAll();
        model.addAttribute("services",services);
        model.addAttribute("title", "Просмотр автосервиса "+autoservice.getName());
        return "one_autoservice";
    }

    @GetMapping("add_autoservice_admin")
    public String showPageForAdd(Model model){
        model.addAttribute("is_update", false);
        List<Service> services = serviceRepository.findAll();
        model.addAttribute("services",services);
        model.addAttribute("title", "Добавление автосервиса ");
        return "add_autoservice_admin";
    }

    @GetMapping("one_autoservice_admin/{id}")
    public String showAutoserviceForEdit(@PathVariable Long id, Model model){
        Autoservice autoservice = autoserviceRepository.getOne(id);
        model.addAttribute("autoservice", autoservice);
        List<Service> services = serviceRepository.findAll();
        model.addAttribute("services",services);
        model.addAttribute("is_update", true);
        model.addAttribute("title", "Редактирование автосервиса "+autoservice.getName());
        return "one_autoservice_admin";
    }

    @PostMapping("/api/autoservice/update/{id}")
    public String updateAutoservice(@PathVariable Long id, @RequestParam String name,
                                    @RequestParam String address, @RequestParam String tel, @RequestParam String email
            , @RequestParam String description, @RequestParam String dateAdd, @RequestParam String photoPath, @RequestBody String requestBody){
        Autoservice autoservice = autoserviceRepository.getOne(id);
        autoservice.setAddress(address);
        autoservice.setName(name);
        autoservice.setTel(tel);
        autoservice.setEmail(email);
        autoservice.setDescription(description);
        List<Service> services = new ArrayList<>();
        for(Long id_service: ParseCheckboxFromBody.getResult(requestBody)){
            services.add(serviceRepository.getOne(id_service));
        }
        autoservice.setServiceList(services);
        if(!photoPath.isEmpty())
            autoservice.setPhotoPath("/assets/services/"+photoPath);
        try{
            autoservice.setDateAdd(Date.valueOf(dateAdd));
        }catch(Exception e){
            e.printStackTrace();
        }

        autoserviceRepository.save(autoservice);
        return "redirect:/";

    }
    @PostMapping("/api/autoservice/add")
    public String addAutoservice( @RequestParam String name, @RequestParam String address, @RequestParam String tel, @RequestParam String email
            , @RequestParam String description, @RequestParam String dateAdd, @RequestParam String photoPath, @RequestBody String requestBody){
        Autoservice autoservice = new Autoservice();
        autoservice.setAddress(address);
        autoservice.setName(name);
        autoservice.setTel(tel);
        autoservice.setEmail(email);
        autoservice.setDescription(description);
        List<Service> services = new ArrayList<>();
        for(Long id_service: ParseCheckboxFromBody.getResult(requestBody)){
            services.add(serviceRepository.getOne(id_service));
        }
        autoservice.setServiceList(services);
        if(!photoPath.isEmpty())
            autoservice.setPhotoPath("/assets/services/"+photoPath);
        try{
            if(dateAdd != null && !dateAdd.isEmpty())
                autoservice.setDateAdd(Date.valueOf(dateAdd));
        }catch(Exception e){
            e.printStackTrace();
        }

        autoserviceRepository.save(autoservice);
        return "redirect:/";
    }

    @PostMapping("/api/autoservice/delete/{id}")
    public String deleteAutoservice(@PathVariable Long id, Model model){
        try {
            Autoservice autoservice = autoserviceRepository.getOne(id);
            autoservice.setServiceList(List.of());
            autoserviceRepository.deleteById(id);
            //autoserviceRepository.delete(autoservice);
        }catch (Exception e){
            e.printStackTrace();
        }
        return "redirect:/";
    }
}
